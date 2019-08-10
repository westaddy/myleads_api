<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$router->get('/', function () use ($router) {
    return $router->app->version();
});

//Login related routes
$router->post('login', 'Auth\LoginController@login');
$router->post('logout', 'Auth\LoginController@logout');
$router->post('register', 'Auth\RegisterController@register');
$router->post('password/email', ['as' => 'password.email', 'uses' => 'Auth\ResetPasswordController@sendResetLinkEmail']);

$router->group(['prefix' => 'leads'], function($app) {
    //profile related routes
    $app->get('', 'LeadController@index');
    $app->get('create', 'LeadController@create');
    $app->post('', 'LeadController@store');
    $app->get('{id}', 'LeadController@show');
    $app->get('{id}/edit', 'LeadController@edit');
    $app->put('{id}', 'LeadController@update');
    $app->delete('{id}', 'LeadController@destroy');
});
