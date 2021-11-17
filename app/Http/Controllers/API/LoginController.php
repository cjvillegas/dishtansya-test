<?php

namespace App\Http\Controllers\API;

use Tymon\JWTAuth\Exceptions\JWTException;
use App\Http\Controllers\Controller;
use App\Http\Requests\API\LoginRequest;
use Illuminate\Http\JsonResponse;
use Tymon\JWTAuth\Facades\JWTAuth;

class LoginController extends Controller
{
    /**
     * Login endpoint. This will generate a JW Token for authorization
     *
     * @param  LoginRequest  $request
     *
     * @return JsonResponse
     */
    public function login(LoginRequest $request)
    {
        // we will now attempt to authenticate the user as well as generate the JW Token
        try {
            $accessToken = JWTAuth::attempt($request->all());

            // sanity check: early return if invalid cred
            if (empty($accessToken)) {
                return response()->json([
                    'message' => 'Invalid credentials',
                ], 401);
            }

        } catch (JWTException $exception) {
            // Ops! something serious happened
            return response()->json([
                'message' => 'Could not create token.',
            ], 500);
        }

        // Ayt! token is created and now we are off to go!
        return response()->json([
            'access_token' => $accessToken,
        ], 201);
    }
}
