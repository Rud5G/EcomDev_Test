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



// Inclusion of files under test
$paths = explode(PATH_SEPARATOR, get_include_path());
array_unshift($paths, '../app/code/local');
array_unshift($paths, '../app/code/community');
array_unshift($paths, '../app/code/core');
array_unshift($paths, '../lib');
array_unshift($paths, '../tests');
set_include_path(implode(PATH_SEPARATOR, $paths));

if (!defined('DS')) {
    define('DS', DIRECTORY_SEPARATOR);
    define('BP', dirname(__DIR__));
    define('PS', PATH_SEPARATOR);
}

spl_autoload_register(function ($className) {
    $filePath = strtr($className, array(
        '_' => DS,
        '\\' => DS
    ));

    @include $filePath . '.php';
});