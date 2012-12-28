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
                    'Module' => array(
                        'Name' => array(
                            'data' => array(
                                'module_name_setup' => array(
                                    'data-install-1.0.0.php' => ''
                                )
                            ),
                            'sql' => array(
                                'module_name_setup'  => array(
                                    'install-1.0.0.php' => '',
                                    'upgrade-1.0.0-1.0.1.php' => '',
                                    'upgrade-1.0.1-1.0.3.php' => '',
                                    'some-not-related-file.php' => ''
                                )
                            )
                        ),
                        'Name2' => array(
                            'sql' => array(
                                'module_name2_setup'  => array(
                                    'mysql4-data-install-1.0.0.php' => '',
                                    'mysql4-install-1.0.0.php' => '',
                                    'mysql4-upgrade-1.0.0-1.0.1.php' => '',
                                    'mysql4-upgrade-1.0.1-1.0.3.php' => ''
                                )
                            )
                        )
                    )
                )
            )
        )
    )
);
