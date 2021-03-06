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