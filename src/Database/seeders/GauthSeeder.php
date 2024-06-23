<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Geekpack\Api\Models\ApiRoute;

class GauthSeeder extends Seeder
{
    public function run()
    {
        $routes = [
            [
                'type' => 'post', 
                'route' => 'api/register', 
                'controller' => 'Geekpack\Gauth\Http\Controllers\AuthController', 
                'class' => 'register', 
                'name' => 'api.register'
            ],
            [
                'type' => 'post', 
                'route' => 'api/login', 
                'controller' => 'Geekpack\Gauth\Http\Controllers\AuthController', 
                'class' => 'login', 
                'name' => 'api.login'],
            [

                'type' => 'post', 
                'route' => 'api/logout', 
                'controller' => 'Geekpack\Gauth\Http\Controllers\AuthController', 
                'class' => 'logout', 
                'name' => 'api.logout', 
                'middleware' => 'auth:sanctum'],
            [

                'type' => 'post', 
                'route' => 'api/forgot-password', 
                'controller' => 'Geekpack\Gauth\Http\Controllers\AuthController', 
                'class' => 'forgotPassword', 
                'name' => 'api.forgot-password'],
            [

                'type' => 'post', 
                'route' => 'api/reset-password', 
                'controller' => 'Geekpack\Gauth\Http\Controllers\AuthController', 
                'class' => 'resetPassword', 
                'name' => 'api.password.update'],
            [
                'type' => 'get', 
                'route' => 'api/email/verify', 
                'controller' => 'Geekpack\Gauth\Http\Controllers\AuthController', 
                'class' => 'emailVerificationNotice', 
                'name' => 'verification.notice'],
            [

                'type' => 'get', 
                'route' => 'api/email/verify/{id}/{hash}', 
                'controller' => 'Geekpack\Gauth\Http\Controllers\AuthController', 
                'class' => 'verify', 
                'name' => 'verification.verify'],
            [
                'type' => 'post', 
                'route' => 'api/email/resend', 
                'controller' => 'Geekpack\Gauth\Http\Controllers\AuthController', 
                'class' => 'resendVerificationEmail', 
                'name' => 'verification.send'],
            [
                'type' => 'get', 
                'route' => 'login', 
                'controller' => 'Geekpack\Gauth\Http\Controllers\AuthController', 
                'class' => 'showLogin', 
                'name' => 'login'],
            [
                'type' => 'get', 
                'route' => 'register', 
                'controller' => 'Geekpack\Gauth\Http\Controllers\AuthController', 
                'class' => 'showRegister', 
                'name' => 'register'],
            [
                'type' => 'get', 
                'route' => 'verifyemail', 
                'controller' => 'Geekpack\Gauth\Http\Controllers\AuthController', 
                'class' => 'showVerifyEmail', 
                'name' => 'verifyemail'],
        ];

        foreach ($routes as $routeData) {
            ApiRoute::create($routeData);
        }
    }
}