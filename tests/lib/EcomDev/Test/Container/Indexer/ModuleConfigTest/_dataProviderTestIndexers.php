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
 * @package    EcomDev_Test
 * @copyright  Copyright (c) 2012 EcomDev BV (http://www.ecomdev.org)
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 * @author     Ivan Chepurnyi <ivan.chepurnyi@ecomdev.org>
 */

$xmlConfig = include __DIR__ . DS . '_xmlConfig.php';
return array(
    array(
        'indexModules',
        new SimpleXMLElement($xmlConfig),
        array(

            'Module_Name' => array(
                'version' => '1.0.0',
                'codePool' => 'core',
                'depends' => array()
            ),
            'Module_Name1' => array(
                'version' => '1.0.1',
                'codePool' => 'core',
                'depends' => array()
            ),
            'Module_Name2' => array(
                'version' => '1.0.2',
                'codePool' => 'core',
                'depends' => array()
            ),
            'Module_Name4' => array(
                'version' => '1.0.4',
                'codePool' => 'community',
                'depends' => array()
            ),
            'Module_Name5' => array(
                'version' => '1.0.5',
                'codePool' => 'community',
                'depends' => array()
            ),
            'Module_Name7' => array(
                'version' => '1.0.7',
                'codePool' => 'local',
                'depends' => array()
            ),
            'Module_Name8' => array(
                'codePool' => 'local',
                'depends' => array(
                    'Module_Name7'
                )
            )
        )
    ),
    array(
        'indexAliases',
        new SimpleXMLElement($xmlConfig),
        array(
            'models' => array(
                'rewrite' => array(
                    'module_name2/model_name' => 'Module_Name5_Model_Model_Name'
                ),
                'prefix' => array(
                    'module_name' => 'Module_Name_Model',
                    'module_name1' => 'Module_Name1_Model',
                    'module_name2' => 'Module_Name2_Model',
                    'module_name2_resource' => 'Module_Name2_Model_Resource',
                )
            ),
            'helpers' => array(
                'prefix' => array(
                    'module_name' => 'Module_Name_Helper',
                    'module_name1' => 'Module_Name1_Helper',
                )
            ),
            'blocks' => array(
                'rewrite' => array(
                    'module_name2/block_name' => 'Module_Name5_Block_Block_Name'
                ),
                'prefix' => array(
                    'module_name' => 'Module_Name_Block',
                    'module_name2' => 'Module_Name2_Block'
                )
            ),
            'resources' => array (
                'prefix' => array (
                    'module_name' => 'Module_Name_Model_Resource',
                    'module_name1' => 'Module_Name_Model_Resource'
                ),
                'rewrite' => array (
                    'module_name1/model_name' => 'Module_Name2_Model_Resource_Model_Name'
                )
            ),
            'tables' => array(
                'rewrite' => array(
                    'module_name/core' => 'module_core',
                    'module_name/another_core' => 'module_another_core'
                )
            )
        )
    ),
    array(
        'indexSetup',
        new SimpleXMLElement($xmlConfig),
        array(
            'defined' => array(
                'Module_Name' => array(
                    'module_name_setup' => 'Mage_Core_Model_Resource_Setup'
                ),
                'Module_Name1' => array(
                    'module_name1_setup' => 'Mage_Core_Model_Resource_Setup'
                ),
                'Module_Name2' => array(
                    'module_name2_setup' => 'Module_Name2_Model_Resource_Setup'
                )
            ),
            'data' => array(
                'Module_Name' => array(
                    'module_name_setup' => array(
                        'data-install-1.0.0.php'
                    )
                ),
                'Module_Name2' => array(
                    'module_name2_setup' => array(
                        'mysql4-data-install-1.0.0.php'
                    )
                )
            ),
            'schema' => array(
                'Module_Name' => array(
                    'module_name_setup' => array(
                        'install-1.0.0.php',
                        'upgrade-1.0.0-1.0.1.php',
                        'upgrade-1.0.1-1.0.3.php'
                    )
                ),
                'Module_Name2' => array(
                    'module_name2_setup' => array(
                        'mysql4-install-1.0.0.php',
                        'mysql4-upgrade-1.0.0-1.0.1.php',
                        'mysql4-upgrade-1.0.1-1.0.3.php'
                    )
                )
            )
        )
    )
);