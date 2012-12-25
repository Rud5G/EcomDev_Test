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
    )
);