<?php
/**
 * Test Framework for Magento for Integration with various test solutions
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 *
 * @category   EcomDev
 * @package    EcomDev\Test
 * @copyright  Copyright (c) 2012 EcomDev BV (http://www.ecomdev.org)
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 * @author     Ivan Chepurnyi <ivan.chepurnyi@ecomdev.org>
 */
namespace EcomDev\Test\Container\Indexer;

/**
 * Module configuration indexer
 *
 */
use EcomDev\Test\Util\FileSystem;

/**
 * Module Configuration file indexer
 */
class ModuleConfig extends ConfigAbstract
{
    const REGEXP_INSTALL_FILE = '/^(mysql4-)?(install|data-install)-.*?\.php$/';
    const REGEXP_UPGRADE_FILE = '/^(mysql4-)?(upgrade|data-upgrade)-.*?-.*?\.php$/';
    const DEFAULT_SETUP_CLASS = 'Mage_Core_Model_Resource_Setup';

    /**
     * Indexes module configuration
     *
     * @return array
     */
    public function index()
    {
        return array(
            'modules' => $this->indexModules(),
            'aliases' => $this->indexAliases(),
            'setup'   => $this->indexSetup()
        );
    }

    /**
     * Returns module nodes index
     *
     * @return array
     */
    public function indexModules()
    {
        $result = array();

        if (isset($this->getSource()->modules)) {
            foreach ($this->getSource()->modules->children() as $module) {
                if (!in_array((string)$module->active, array('true', '1'), true)) {
                    continue;
                }
                $moduleInfo = array();
                if (isset($module->version)) {
                    $moduleInfo['version'] = (string)$module->version;
                }
                $moduleInfo['codePool'] = (string)$module->codePool;
                $moduleInfo['depends'] = array();
                if (isset($module->depends)) {
                    foreach ($module->depends->children() as $dependsOnModule) {
                        $moduleInfo['depends'][] = $dependsOnModule->getName();
                    }
                }
                $result[$module->getName()] = $moduleInfo;
            }
        }

        return $result;
    }

    public function indexAliases()
    {
        $types = array('models', 'helpers', 'blocks');
        $result = array();
        $resources = array();
        foreach ($types as $type) {
            if (isset($this->getSource()->global->$type)) {
                $container = $this->getSource()->global->$type;
                foreach ($container->children() as $node) {
                    if (isset($node->resourceModel) && $type === 'models') {
                        $resources[(string)$node->resourceModel]['alias'] = $node->getName();
                    }

                    if (isset($node->entities) && $type === 'models') {
                        $resources[$node->getName()]['tables'] = array();
                        foreach ($node->entities->children() as $table) {
                            if (!isset($table->table)) {
                                continue;
                            }
                            $resources[$node->getName()]['tables'][$table->getName()] = (string)$table->table;
                        }
                    }

                    if (isset($node->rewrite)) {
                        foreach ($node->rewrite->children() as $rewrite) {
                            $result[$type]['rewrite'][$node->getName() . '/' . $rewrite->getName()] = (string) $rewrite;
                        }
                    }

                    $result[$type]['prefix'][$node->getName()] = (string)$node->class;
                }
            }
        }

        foreach ($resources as $prefix => $info) {
            if (!isset($info['alias']) || !isset($result['models']['prefix'][$prefix])) {
                continue;
            }

            $result['resources']['prefix'][$info['alias']] = $result['models']['prefix'][$prefix];
            unset($result['models']['prefix'][$prefix]); // Remove resource model from models
            foreach ($result['models']['rewrite'] as $alias => $class) {
                if (strpos($alias, $prefix . '/') === 0) {
                    $realAlias = $info['alias'] . '/' . substr($alias, strlen($prefix)+1);
                    $result['resources']['rewrite'][$realAlias] = $class;
                    unset($result['models']['rewrite'][$alias]);
                }
            }

            if (isset($info['tables'])) {
                foreach ($info['tables'] as $alias => $realTable) {
                     $result['tables']['rewrite'][$info['alias'] . '/' . $alias] = $realTable;
                }
            }
        }
        return $result;
    }

    /**
     * Indexes setup resources
     *
     */
    public function indexSetup()
    {
        $result = array();

        if (isset($this->getSource()->global->resources)) {
            foreach ($this->getSource()->global->resources->children() as $resource) {
                if (isset($resource->setup) && isset($resource->setup->module)) {
                    $moduleName = (string)$resource->setup->module;

                    if (!isset($this->getSource()->modules->$moduleName->codePool)) {
                        continue;
                    }

                    $moduleDirectory = FileSystem::getModuleDirectory(
                        $moduleName,
                        (string)$this->getSource()->modules->$moduleName->codePool
                    );

                    if ($moduleDirectory === false) {
                        continue;
                    }

                    $setupClass = isset($resource->setup->class)
                                    ? (string)$resource->setup->class
                                    : self::DEFAULT_SETUP_CLASS;

                    $result['defined'][$moduleName][$resource->getName()] = $setupClass;

                    $searchSubDirectories = array(
                        $moduleDirectory->getPath() . '/sql/' . $resource->getName(),
                        $moduleDirectory->getPath() . '/data/' . $resource->getName(),
                    );

                    foreach ($searchSubDirectories as $subDirectory) {
                        if (!is_dir($subDirectory)) {
                            continue;
                        }

                        foreach (new \DirectoryIterator($subDirectory) as $file) {
                            /* @var \SplFileInfo $file */
                            if (!$file->isFile()
                                || (!preg_match(self::REGEXP_INSTALL_FILE, $file->getBasename())
                                    && !preg_match(self::REGEXP_UPGRADE_FILE, $file->getBasename()))) {
                                continue;
                            }

                            if (strpos($file->getBasename(), 'data-') !== false) {
                                $result['data'][$moduleName][$resource->getName()][] = $file->getBasename();
                            } else {
                                $result['schema'][$moduleName][$resource->getName()][] = $file->getBasename();
                            }
                        }
                    }
                }
            }
        }
        return $result;
    }
}