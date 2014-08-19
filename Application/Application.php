<?php

namespace Application;

/**
 * Main Application class
 * @package Application
 */

class Application
{
    /**
     * @var array Specific parameters for the application to run
     */
    protected $params;

    /*
     * Setting defaults
     */
    protected $defaultController = 'Users';
    protected $defaultAction = 'index';

    /**
     * @ignore
     * @param array $params Specific parameters for the application to run
     */
    public function __construct($params = array())
    {
        if (is_array($params)) {
            $this->params = $params;
        }

        // todo: add option to change default controller/action through params
    }

    /**
     * Initializing required application elements
     */
    public function init()
    {
        // Setting autoloader
        require_once __DIR__ . '/Autoloader.php';
        $autoloader = new Autoloader();
        spl_autoload_register(array($autoloader, 'load'));

        // Sugar to Application - global functions to make development faster
        require_once __DIR__ . '/Functions.php';
    }

    /**
     * Main method to run the application.
     */
    public function run()
    {
        $content = $this->handleRequest();
        echo $content;

        $this->close();
    }

    public function handleRequest()
    {
        // Get Request
        // Parse request
        // Load required controller
        // Execute required method

        $server = $_SERVER;
        $applicationPath = substr($server['SCRIPT_NAME'], 0, strrpos($server['SCRIPT_NAME'], '/') + 1);

        // getting request uri, starting with controller
        $request = substr($server['REQUEST_URI'], strlen($applicationPath));
        $request = trim($request, '/'); // removing unnecessary slashes
        $request = explode('/', $request);

        $controller = ucfirst(array_shift($request));

        $action = array_shift($request);

        $vars = implode('/', $request); // bringing back to a string for quick regexp that pushes to pairs
        $vars .= '/ '; // fixing vars if value is missing (needs for API)
        preg_match_all("/([^\/]+)\/([^\/]+)/", $vars, $pairs);
        $vars = array_combine($pairs[1], $pairs[2]);

        // if controller doesn't exists, moving to default
        if (!$controller) {
            $controller = $this->defaultController;
        }

        // if action doesn't exists, moving to default
        if (!$action) {
            $action = $this->defaultAction;
        }

        // loading controller and action
        $content = '';
        $controllerClass = '\Application\\' . $controller . '\Controller';
        if (!class_exists($controllerClass)) {
            throw new \Exception('Controller doesn\'t exist (' . $controller . ').');
        } else {
            $plugin = new $controllerClass();

            if(!method_exists($plugin, $action)) {
                throw new \Exception('Action/method doesn\'t exist (' . $controller . '->' . $action . ')');
            } else {
                $content = $plugin->$action($vars);
            }
        }

        return $content;
    }

    /**
     * All maintenance after the application is finished its work (disconnecting from DB, etc.)
     */
    public function close()
    {
        // TODO: write to DB all changes to data from all Plugins
    }
}
