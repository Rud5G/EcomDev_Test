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

$baseIndex = array(
    'modules' => array(
        'Module_Name' => array(
            'codePool' => 'local',
            'active' => true,
            'version' => '1.0.0'
        ),
        'Module_Name2' => array(
            'codePool' => 'local',
            'active' => true,
            'version' => '1.0.1',
            'depends' => array(
                'Module_Name'
            )
        ),
        'Module_Name3' => array(
            'codePool' => 'community',
            'active' => true,
            'version' => '1.0.0',
            'depends' => array(
                'Module_Name2'
            )
        ),
        'Module_Name4' => array(
            'codePool' => 'local',
            'active' => false,
            'version' => '1.2.0',
            'depends' => array(
                'Module_Name3'
            )
        )
    ),
    'aliases' => array(
        'models' => array(
            'module' => array(
                'prefix' => 'Module_Name_Model',
                'rewrite' => array(
                    'name' => 'Module_Name_Model_Name'
                )
            ),
            'module2' => array(
                'prefix' => 'Module_Name2_Model',
                'rewrite' => array(
                    'name' => 'Module_Name2_Model_Name'
                )
            )
        )
    ),
    'events' => array(
        array(
            'event' => 'event_name',
            'name' => 'observer_name',
            'class' => 'class/name',
            'type'  => 'model',
            'method' => 'method',
            'scope' => 'frontend'
        ),
        array(
            'event' => 'event_name',
            'name' => 'observer_name',
            'class' => 'class/name',
            'type'  => 'model',
            'method' => 'method',
            'scope' => 'adminhtml'
        ),
        array(
            'event' => 'event_name',
            'name' => 'observer_name',
            'class' => 'class/name',
            'type'  => 'model',
            'method' => 'method',
            'scope' => 'global'
        )
    )
);

return array(
    'modules_active' => array(
        $baseIndex,
        'modules/active=1',
        array(
            'Module_Name' => array(
                'codePool' => 'local',
                'active' => true,
                'version' => '1.0.0'
            ),
            'Module_Name2' => array(
                'codePool' => 'local',
                'active' => true,
                'version' => '1.0.1',
                'depends' => array(
                    'Module_Name'
                )
            ),
            'Module_Name3' => array(
                'codePool' => 'community',
                'active' => true,
                'version' => '1.0.0',
                'depends' => array(
                    'Module_Name2'
                )
            )
        )
    ),
    'modules_active_or_from_community_depends' => array(
        $baseIndex,
        'modules/active||codePool=community&&depends~Module_Name||depends~Module_Name2',
        array(
            'Module_Name2' => array(
                'codePool' => 'local',
                'active' => true,
                'version' => '1.0.1',
                'depends' => array(
                    'Module_Name'
                )
            ),
            'Module_Name3' => array(
                'codePool' => 'community',
                'active' => true,
                'version' => '1.0.0',
                'depends' => array(
                    'Module_Name2'
                )
            )
        )
    ),
    'module_version_contains' => array(
        $baseIndex,
        'modules/version~.0.0',
        array(
            'Module_Name' => array(
                'codePool' => 'local',
                'active' => true,
                'version' => '1.0.0'
            ),
            'Module_Name3' => array(
                'codePool' => 'community',
                'active' => true,
                'version' => '1.0.0',
                'depends' => array(
                    'Module_Name2'
                )
            )
        )
    ),
    'module_version_not_contains' => array(
        $baseIndex,
        'modules/version!~.0.0',
        array(
            'Module_Name2' => array(
                'codePool' => 'local',
                'active' => true,
                'version' => '1.0.1',
                'depends' => array(
                    'Module_Name'
                )
            ),
            'Module_Name4' => array(
                'codePool' => 'local',
                'active' => false,
                'version' => '1.2.0',
                'depends' => array(
                    'Module_Name3'
                )
            )
        )
    ),
    'module_version_more_than_0_and_less_than_equals_1.0.1' => array(
        $baseIndex,
        'modules/version>0&&version<=1.0.1',
        array(
            'Module_Name' => array(
                'codePool' => 'local',
                'active' => true,
                'version' => '1.0.0'
            ),
            'Module_Name2' => array(
                'codePool' => 'local',
                'active' => true,
                'version' => '1.0.1',
                'depends' => array(
                    'Module_Name'
                )
            ),
            'Module_Name3' => array(
                'codePool' => 'community',
                'active' => true,
                'version' => '1.0.0',
                'depends' => array(
                    'Module_Name2'
                )
            ),
        )
    ),
    'module_version_less_than_2.0.0_and_more_than_equals_1.2.0' => array(
        $baseIndex,
        'modules/version<2.0.0&&version>=1.2.0',
        array(
            'Module_Name4' => array(
                'codePool' => 'local',
                'active' => false,
                'version' => '1.2.0',
                'depends' => array(
                    'Module_Name3'
                )
            )
        )
    ),
    'rewrite' => array(
        $baseIndex,
        'aliases/models/module/rewrite/name',
        array(
            'Module_Name_Model_Name'
        )
    ),
    'events' => array(
        $baseIndex,
        'events/event=event_name&&scope=global||scope=frontend',
        array(
            0 => array(
                'event' => 'event_name',
                'name' => 'observer_name',
                'class' => 'class/name',
                'type'  => 'model',
                'method' => 'method',
                'scope' => 'frontend'
            ),
            2 => array(
                'event' => 'event_name',
                'name' => 'observer_name',
                'class' => 'class/name',
                'type'  => 'model',
                'method' => 'method',
                'scope' => 'global'
            )
        )
    ),
    'false' => array(
        $baseIndex,
        'events/event=event_name&scope=global|scope=frontend',
        false
    ),
    'false_condition' => array(
        $baseIndex,
        'events/event=event_name&&scope=global/scope/scope=global',
        false
    ),
    'all_rewrites' => array(
        $baseIndex,
        'aliases/models/*/rewrite',
        array(
            'module' => array(
                'name' => 'Module_Name_Model_Name'
            ),
            'module2' => array(
                'name' => 'Module_Name2_Model_Name'
            )
        )
    ),
    'false_unknown_node' => array(
        $baseIndex,
        'aliases/models/*/unknown',
        false
    ),
    'false_unknown_node_child' => array(
        $baseIndex,
        'aliases/models/*/rewrite/unknown',
        false
    )
);