<?php

namespace App\Api\V1\Controllers\Authentication;

use JWTAuth;

class TokenController
{

    public static function getCompanyId()
    {
        return static::getUser()->company->id;
    }

    public static function getUser()
    {
        return JWTAuth::parseToken()->toUser();
    }

    public static function createTokenFromPayload($payload)
    {
        $user = static::getUser();
        $token = JWTAuth::fromUser($user, $payload);
        return $token;
    }
}