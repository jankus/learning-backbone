<?php

function appUrl($path = '')
{
    $protocol = 'http://';
    $server = $_SERVER;

    $root = $server["HTTP_HOST"];
    $baseUrl = substr($server['SCRIPT_NAME'], 0, strrpos($server['SCRIPT_NAME'], '/') + 1);
    $root .= rtrim($baseUrl, '/') . '/';

    if (isset($server['HTTPS']) && $server['HTTPS'] == "on") {
        $protocol = 'https://';
    }

    $url = $protocol . $root . $path;

    return $url;
}

function appView($file)
{
    $file = str_replace('/', DIRECTORY_SEPARATOR, $file);
    $fullpath = __DIR__ . $file;

    if (!is_file($fullpath)) {
        throw new Exception('View file doesn\'t exist: ' . $fullpath);
    }

    return $fullpath;
}
