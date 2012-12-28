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

return '<?xml version="1.0"?>
<config>
   <modules>
        <Module_Name>
            <active>true</active>
            <codePool>core</codePool>
            <version>1.0.0</version>
        </Module_Name>
        <Module_Name1>
            <active>true</active>
            <codePool>core</codePool>
            <version>1.0.1</version>
        </Module_Name1>
        <Module_Name2>
            <active>true</active>
            <codePool>core</codePool>
            <version>1.0.2</version>
        </Module_Name2>
        <Module_Name3>
            <active>false</active>
            <codePool>core</codePool>
            <version>1.0.3</version>
        </Module_Name3>
        <Module_Name4>
            <active>true</active>
            <codePool>community</codePool>
            <version>1.0.4</version>
        </Module_Name4>
        <Module_Name5>
            <active>true</active>
            <codePool>community</codePool>
            <version>1.0.5</version>
        </Module_Name5>
        <Module_Name6>
            <active>false</active>
            <codePool>community</codePool>
            <version>1.0.6</version>
        </Module_Name6>
        <Module_Name7>
            <active>true</active>
            <codePool>local</codePool>
            <version>1.0.7</version>
        </Module_Name7>
        <Module_Name8>
            <active>true</active>
            <codePool>local</codePool>
            <depends><Module_Name7 /></depends>
        </Module_Name8>
   </modules>
   <global>
        <models>
            <module_name>
                <class>Module_Name_Model</class>
                <resourceModel>module_name_resource</resourceModel>
            </module_name>
            <module_name_resource>
                <class>Module_Name_Model_Resource</class>
                <entities>
                    <core><table>module_core</table></core>
                    <another_core><table>module_another_core</table></another_core>
                    <invalid>invalid_table</invalid>
                </entities>
            </module_name_resource>
            <module_name1>
                <class>Module_Name1_Model</class>
                <resourceModel>module_name1_resource</resourceModel>
            </module_name1>
            <module_name1_resource>
                <class>Module_Name_Model_Resource</class>
                <rewrite>
                    <model_name>Module_Name2_Model_Resource_Model_Name</model_name>
                </rewrite>
            </module_name1_resource>
            <module_name2>
                <class>Module_Name2_Model</class>
                <rewrite>
                    <model_name>Module_Name5_Model_Model_Name</model_name>
                </rewrite>
            </module_name2>
            <!-- this one will not be included to resources -->
            <module_name2_resource>
                <class>Module_Name2_Model_Resource</class>
            </module_name2_resource>
        </models>
        <helpers>
            <module_name>
                <class>Module_Name_Helper</class>
            </module_name>
            <module_name1>
                <class>Module_Name1_Helper</class>
            </module_name1>
        </helpers>
        <blocks>
            <module_name>
                <class>Module_Name_Block</class>
            </module_name>
            <module_name2>
                <class>Module_Name2_Block</class>
                <rewrite>
                    <block_name>Module_Name5_Block_Block_Name</block_name>
                </rewrite>
            </module_name2>
        </blocks>

        <resources>
            <module_name_setup>
                <setup>
                    <module>Module_Name</module>
                </setup>
            </module_name_setup>
            <module_name2_setup>
                <setup>
                    <class>Module_Name2_Model_Resource_Setup</class>
                    <module>Module_Name2</module>
                </setup>
            </module_name2_setup>
            <unknown_module_setup>
                <setup>
                    <module>Unknown_Module</module>
                </setup>
            </unknown_module_setup>
        </resources>
   </global>
</config>';