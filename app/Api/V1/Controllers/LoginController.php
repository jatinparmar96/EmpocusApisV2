<?php

namespace App\Api\V1\Controllers;

use App\Api\V1\Requests\LoginRequest;
use App\Http\Controllers\Controller;
use Auth;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\JWTAuth;

class LoginController extends Controller
{
    /**
     * Log the user in
     *
     * @param LoginRequest $request
     * @param JWTAuth $JWTAuth
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(LoginRequest $request, JWTAuth $JWTAuth)
    {
        $credentials = $request->only(['email', 'password']);
        try {
            $token = Auth::guard()->attempt($credentials);
            if (!$token) {
                return response()
                    ->json([
                        'status' => false,
                        'status_code' => 200,
                        'message' => 'Incorrect User Name or Password',
                    ]);
            }
        } catch (JWTException $e) {
            throw new HttpException(500);
        }

        return response()
            ->json([
                'status' => true,
                'token' => $token,
                'expires_in' => Auth::guard()->factory()->getTTL() * 60
            ]);
    }
}
