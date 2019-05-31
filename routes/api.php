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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware(['auth:api' , 'admin'])->group(function (){
    Route::get('/tasks', function (){
        $tasks = [
            'Login Page For Admin',
            'Forgot Password For Users',
            'Admin Can Add New User'
        ];
    
        return response()->json(['tasks' => $tasks]);
    });
    Route::post('register', 'API\UserController@register');
});
Route::post('login', 'API\UserController@login');
Route::get('test', function (){
    return response()->json('Test Route...');
})