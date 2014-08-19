<?php

namespace Application;

/**
 * Autoloader class
 * @package Application
 */
class Autoloader
{
    public function load($name)
    {

        $fileName = str_replace('\\', '/', $name) . '.php';
        if ($fileName[0] == '/') { //in some environments required class starts with slash. In that case remove the slash.
            $fileName = substr($fileName, 1);
        }

        $possibleFilename = dirname(__DIR__) . '/' . $fileName;

        if (file_exists($possibleFilename)) {
            require_once $possibleFilename;
            return true;
        }

        return false;

    }
}
