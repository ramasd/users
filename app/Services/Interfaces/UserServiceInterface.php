<?php

namespace App\Services\Interfaces;

interface UserServiceInterface
{
    /**
     * @param $users
     * @return array|\string[][]
     */
    public function getFullNames($users);
}
