<?php

namespace Application\Users;


use Application\DB;

class Model
{
    const DB = 'Users';
    protected static $usersRaw;
    protected static $users;

    public static function getTitle()
    {
        return 'Users';
    }

    public static function getAllUsers($returnRaw = false)
    {

        if (!static::$users) {
            static::$usersRaw = DB::read(self::DB);

            // changing raw data to assoc array to have keys as IDs
            $decoded = json_decode(static::$usersRaw, true);
            $_users = array();
            foreach ($decoded as $val) {
                $_users[$val['id']] = $val;
            }
            static::$users = $_users;
        }

        if ($returnRaw) {
            return static::$usersRaw;
        }
        return static::$users;
    }

    public static function setAllUsers($users)
    {
        // rebuilding PHP assoc array to simple array for storing raw data
        $_users = array();
        foreach ($users as $key => $value) {
            $_users[] = $value;
        }

        // caching new data
        self::$users = $users;
        self::$usersRaw = json_encode($_users);

        // writing data to DB
        // todo: write to DB only when application finishes (in case of multiple data changes)
        DB::write(self::DB, self::$usersRaw);
    }

    public static function getUserById($id)
    {

    }

    public static function addUser($data)
    {
        $users = self::getAllUsers();

        // getting next ID for new user
        $nextId = max(array_keys($users)) + 1;

        // setting new ID to append model that is sent from front end
        $data['id'] = $nextId;

        // appending users list
        $users[$nextId] = $data;

        self::setAllUsers($users);

        return $data; // returning data to set ID on front end
    }

    public static function deleteUser($id)
    {
        $users = self::getAllUsers();
        unset($users[$id]);

        self::setAllUsers($users);
    }

    public static function updateUser($id, $data)
    {
        $users = self::getAllUsers();

        $users[$id] = $data;

        self::setAllUsers($users);
    }
}
