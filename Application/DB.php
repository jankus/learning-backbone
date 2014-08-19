<?php

namespace Application;


class DB
{
    public static function read($file)
    {
        $fullname = dirname(__DIR__) . '/db/' . $file . '.db';
        if (!is_file($fullname)) {
            throw new \Exception('DB file doesn\'t exist: ' . $file);
        }

        $data = file_get_contents($fullname);

        return $data;
    }

    public static function write($file, $data)
    {
        $fullname = dirname(__DIR__) . '/db/' . $file . '.db';
        if (!is_file($fullname)) {
            throw new \Exception('DB file doesn\'t exist: ' . $file);
        }

        $success = file_put_contents($fullname, $data);

        if ($success === false) {
            throw new \Exception('Error writing to file: ' . $file);
        }
    }
}
