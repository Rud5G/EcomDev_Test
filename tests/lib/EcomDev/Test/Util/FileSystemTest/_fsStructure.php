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

return array(
    'magento' => array(
        'app' => array(
            'Mage.php' => '',
            'code' => array(
                'core' => array(
                    'Mage' => array(
                        'Core' => array(),
                        'Catalog' => array(),
                        'Reports' => array()
                    )
                ),
                'community' => array(
                    'EcomDev' => array(
                        'PHPUnit' => array()
                    )
                )
            )
        )
    ),
    'not_magento' => array(
        'pub' => array(),
        'dir' => array(),
        'another_dir' => array()
    )
);
