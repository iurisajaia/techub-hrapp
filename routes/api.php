<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::middleware(['auth:api' , 'admin'])->group(function (){
    Route::get('/users', 'API\AdminController@users');
    Route::get('makemoderator/{id}', 'API\AdminController@makemoderator');
    Route::post('register', 'API\UserController@register');
});
Route::post('login', 'API\UserController@login');






Route::get('test', function (){
    return response()->json(['test' => 'Test Route...'], 200);
});