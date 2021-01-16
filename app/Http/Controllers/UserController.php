<?php

namespace App\Http\Controllers;

use App\Services\Interfaces\UserServiceInterface;
use Illuminate\Http\Request;

class UserController extends Controller
{
    protected $userService;

    /**
     * UserController constructor.
     * @param UserServiceInterface $userServiceInterface
     */
    public function __construct(UserServiceInterface $userServiceInterface)
    {
        $this->userService = $userServiceInterface;
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $request->validate(
            [
                'users'                 => 'array',
                'users.*'               => 'array',
                'users.*.first_name'    => 'required_with:users.*.last_name|string',
                'users.*.last_name'     => 'required_with:users.*.first_name|string'
            ]
        );

        return response()->json([
            'users' => $this->userService->getFullNames($request->get('users'))
        ]);
    }
}
