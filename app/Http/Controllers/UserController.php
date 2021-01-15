<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserController extends Controller
{
    public function store(Request $request)
    {
        $request->validate(
            [
                'users'                 => 'array',
                'users.*'               => 'array',
                'users.*.first_name'    => 'required|string',
                'users.*.last_name'     => 'required|string'
            ]
        );

        if ($users = $request->get('users')) {
            $users = array_map(function ($user) {
                return ['full_name' => $user['first_name'] . " " . $user['last_name']];
            }, $users);
        } else {
            $users = [];
        }

        return response()->json(['users' => $users]);
    }
}
