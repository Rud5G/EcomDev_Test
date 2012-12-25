<?php

/**
 * Includes content of data file
 *
 * @param string $currentPhpFile
 * @param string $name
 * @return mixed
 */
function includeDataFile($currentPhpFile, $name)
{
    return include dataFilePath($currentPhpFile, $name);
}

/**
 * Returns path to data file, based on current php file location
 *
 * @param string $currentPhpFile
 * @param string $name
 * @return string
 */
function dataFilePath($currentPhpFile, $name)
{
    return dirname($currentPhpFile) . DS . basename($currentPhpFile, '.php') . DS . '_' . $name . '.php';
}
