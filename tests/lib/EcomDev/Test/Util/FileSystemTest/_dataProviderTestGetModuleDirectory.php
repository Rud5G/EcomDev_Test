<?php

return array(
    'core_module_auto' => array(
        'Mage_Core',
        null,
        'magento/app/code/core/Mage/Core'
    ),
    'core_module' => array(
        'Mage_Catalog',
        'core',
        'magento/app/code/core/Mage/Catalog'
    ),
    'community_module' => array(
        'EcomDev_PHPUnit',
        'community',
        'magento/app/code/community/EcomDev/PHPUnit'
    ),
    'non_existent' => array(
        'EcomDevPHPUnit',
        'community',
        false
    )
);