<?php
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