<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
*/


Route::middleware(['auth:api' , 'admin'])->group(function (){ // Only For Admin 
    Route::get('/users', 'API\AdminController@users'); // Get All User
    Route::post('register', 'API\UserController@register'); // Add New User
    Route::post('makemanager/{id}', 'API\AdminController@makemanager'); // Change User Role To Manager
    Route::post('makeviewer/{id}', 'API\AdminController@makeviewer'); // Change User Role To Viewer
    
    Route::post('store-profile', 'API\ProfileController@store'); // Create Profile
    Route::get('all-profiles', 'API\ProfileController@index'); // Get All Profile
    Route::get('profile/{id}', 'API\ProfileController@show'); // Single Profile View
    Route::put('update-profile/{id}', 'API\ProfileController@update'); // Update Profile
    Route::delete('destroy-profile/{id}', 'API\ProfileController@destroy'); // Delete Profile
});

Route::post('login', 'API\UserController@login'); // login
Route::post('/getemail', 'API\SendEmailController@send'); // Send Email
Route::post('/newpassword', 'API\SendEmailController@newpassword'); // Get New Password






use App\User;
Route::get('test', function (Request $request){
   return response()->json(['test' => User::all()], 200);
}); // Test Route 

