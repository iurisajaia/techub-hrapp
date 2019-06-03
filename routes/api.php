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
    Route::post('register', 'API\UserController@register');
    Route::post('makemanager/{id}', 'API\AdminController@makemanager');
    Route::post('makeviewer/{id}', 'API\AdminController@makeviewer');
});
// Route::middleware(['cors'->group(function(){
    Route::post('login', 'API\UserController@login')->middleware('cors');
// }));





use App\User;

Route::get('test', function (Request $request){
   return response()->json(['test' => User::all()], 200);
});
// ->middleware('cors')
Route::post('/getemail', 'API\SendEmailController@send');
Route::post('/newpassword', 'API\SendEmailController@newpassword');