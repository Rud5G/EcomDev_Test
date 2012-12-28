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
    'guess_yml' => array('some-yml-file', array('yml' => 'some_yml_data')),
    'normal_yml' => array('some-yml-file.yml', array('yml' => 'some_yml_data')),
    'guess_yaml' => array('some-yaml-file', array('yaml' => 'some_yaml_data')),
    'normal_yaml' => array('some-yaml-file.yaml', array('yaml' => 'some_yaml_data')),
    'guess_php' => array('guess-php-file', false),
    'normal_php' => array('some-php-file.php', false),
    'not_exists' => array('some-non-existent-file', false),
    'not_exists_yaml' => array('some-non-existent-file.yaml', false),
    'not_exists_php' => array('some-non-existent-file.php', false)
);