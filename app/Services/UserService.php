<?php

namespace App\Services;

use App\Services\Interfaces\UserServiceInterface;

class UserService implements UserServiceInterface
{
    /**
     * @param $users
     * @return array|\string[][]
     */
    public function getFullNames($users)
    {
        if ($users) {
            $users = array_map(function ($user) {
                return ['full_name' => $user['first_name'] . " " . $user['last_name']];
            }, $users);
        } else {
            $users = [];
        }

        return $users;
    }
}
