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
class ModuleConfig extends ConfigAbstract
{
    public function index()
    {
        // Main facade stub
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
}