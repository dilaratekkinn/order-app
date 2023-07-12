<?php

namespace App\Http\Controllers;

use App\Http\ApiResponses\FailResponse;
use App\Http\ApiResponses\SuccessResponse;
use App\Http\Requests\UserLoginRequest;
use App\Http\Resources\UserResource;
use App\Http\Services\UserService;
use Illuminate\Support\Facades\Lang;

class UserController extends Controller
{
    private UserService $userService;
    private FailResponse $failResponse;
    private SuccessResponse $successResponse;

    public function __construct(
        UserService     $userService,
        FailResponse    $failResponse,
        SuccessResponse $successResponse
    )
    {
        $this->userService = $userService;
        $this->failResponse = $failResponse;
        $this->successResponse = $successResponse;
    }


    public function login(UserLoginRequest $request)
    {
        try {
            $user = $this->userService->login(
                $request->only(['userEmail', 'userPassword'])
            );
            return $this->successResponse->setData([
                'user' => new UserResource($user),
                'token' => $user->createToken('user')->accessToken
            ])->setMessages([
                Lang::get('User Log in Successfully'),
            ])->send();
        } catch (\Exception $e) {
            return $this->failResponse->setMessages([
                'main' => $e->getMessage(),
            ])->send();
        }
    }

}
