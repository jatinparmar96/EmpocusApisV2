<?php

use Dingo\Api\Routing\Router;

/** @var Router $api */
$api = app(Router::class);

$api->version('v1', function (Router $api) {
    $api->group(['prefix' => 'auth'], function (Router $api) {
        $api->post('signup', 'App\\Api\\V1\\Controllers\\SignUpController@signUp');
        $api->post('login', 'App\\Api\\V1\\Controllers\\LoginController@login');

        $api->post('recovery', 'App\\Api\\V1\\Controllers\\ForgotPasswordController@sendResetEmail');
        $api->post('reset', 'App\\Api\\V1\\Controllers\\ResetPasswordController@resetPassword');

        $api->post('logout', 'App\\Api\\V1\\Controllers\\LogoutController@logout');
        $api->post('refresh', 'App\\Api\\V1\\Controllers\\RefreshController@refresh');
        $api->get('me', 'App\\Api\\V1\\Controllers\\UserController@me');
    });

    $api->get('hello', function () {
        return response()->json([
            'message' => 'Api is active and is ready to accept requests!!'
        ]);
    });

    $api->group(['middleware' => 'jwt.auth'], function (Router $api) {
        $api->get('refresh', [
            'middleware' => 'jwt.refresh',
            function () {
                return response()->json([
                    'message' => 'By accessing this endpoint, you can refresh your access token at each request. Check out this response headers!'
                ]);
            }
        ]);
        $api->group(['prefix' => 'crm'], function (Router $api) {
            $api->group(['prefix' => 'employee'], function (Router $api) {

                $api->post('', 'App\\Api\\V1\\Controllers\\CRM\\EmployeeController@create');
            });
        });
    });
});
