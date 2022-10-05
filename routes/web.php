<?php
use Illuminate\Support\Facades\Route;

/** @var \Laravel\Lumen\Routing\Router $router */

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

$router->post('/register', 'UsersController@register');

$router->post('/login','UsersController@login');
$router->get('/logout','UsersController@logout');


// Route::get('/user', function () {
//     $router->get('/logout','UsersController@logout');
//     $router->get('/return','UsersController@get');
// })->middleware('auth:api');


// Route::group(['middleware' => 'auth:api'], function () {
//     $router->get('/logout','UsersController@logout');
//     $router->get('/return','UsersController@get');
//     });
    

$router->get('/refresh','UsersController@refresh');

