<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\RegistrationStoreRequest;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class RegistrationController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  RegistrationStoreRequest  $request
     *
     * @return JsonResponse
     */
    public function store(RegistrationStoreRequest $request): JsonResponse
    {
        $user = new User();
        $user->email = $request->get('email');
        $user->password = bcrypt($request->get('password'));
        $user->save();

        return response()->json([
            'message' => 'User successfully registered'
        ], 201);
    }
}
