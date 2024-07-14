<?php

namespace App\Http\Controllers\API;

use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends BaseController
{
    public function register(Request $request)
    {
        $validator = $this->validate($request->all(), User::validations());

        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors(), 400);
        }

        $input = $request->all();

        $input['password'] = bcrypt($input['password']);
        $user = User::create($input);

        return $this->authenticatedUser($user, 'User register successfully.');
    }

    public function login(Request $request): JsonResponse
    {
        $credentials = $request->only('email', 'password');
        if (Auth::attempt($credentials)) {
            $user = Auth::user();

            return $this->authenticatedUser($user, 'User login successfully.');
        }
        return $this->sendError('Unauthorised.', ['error' => 'User Unauthorised']);
    }

    public function authenticate(Request $request): JsonResponse
    {
        $success = $request->user();
        $user = User::where('email', $success->email)->firstOrFail();
        return $this->authenticatedUser($user, "User authenticated");
    }

    private function authenticatedUser(User $user, $message = null) {
        unset($user->password);
        $success = clone $user;
        $success['token'] = $user->createToken('authToken')->plainTextToken;
        unset($success->password);
        return $this->sendResponse($success, $message);
    }
}
