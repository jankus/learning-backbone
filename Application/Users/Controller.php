<?php

namespace Application\Users;

class Controller
{
    public function index($vars)
    {
        // Setting plugins content
        $contentView = appView('/Users/view/users.php');
        $contentData = array(
            'title' => Model::getTitle(),
            'urlAllData' => appUrl('users/getAll'),
            'urlUserData' => appUrl('users/getData/user')
        );
        $content = new \Application\View($contentView, $contentData);
        $content = $content->render();

        // Setting the global layout
        $layoutView = appView('/Core/view/layout.php');
        $data = array(
            'title' => Model::getTitle(),
            'content' => $content
        );
        $view = new \Application\View($layoutView, $data);
        return $view->render();
    }

    /**
     * Separate API action to throw initial data without interrupting with any logic
     *
     * @param $vars
     * @return string Users data in JSON format for Backbone to handle by default
     */
    public function getAll($vars)
    {
        $users = Model::getAllUsers(true);

        return $users;
    }

    /**
     * API action
     * Return null on success or JSON for errors
     *
     * @return null|string
     */
    public function getData($vars)
    {
        // todo: Requests should be handled in application wide perspective
        $method = $_SERVER['REQUEST_METHOD'];

        switch($method) {
            case 'PUT':
                $id = (int)$vars['user'];
                $data = json_decode(file_get_contents("php://input"), true);

                if (is_int($id) && $id > 0) {
                    // if ID is provided, we will update data
                    $return = json_encode(Model::updateUser($id, $data));
                } else {
                    // if no ID or ID is '0', a new user will be created
                    $return = json_encode(Model::addUser($data));
                }
                break;
            case 'DELETE':
                $id = $vars['user'];
                Model::deleteUser($id);
                $return = json_encode(null);
                break;
            default:
                $return = null;
                break;
        }
        return $return;
    }
}
