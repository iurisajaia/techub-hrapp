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
    Route::post('storeprofile', 'API\AdminController@storeprofile'); // Create Profile
    Route::get('viewprofiles', 'API\AdminController@viewprofiles'); // Get All Profile
    Route::get('profile/{id}', 'API\AdminController@singleprofile'); // Single Profile View
    Route::put('update-profile/{id}', 'API\AdminController@update_profile'); // Update Profile
    Route::delete('destroy-profile/{id}', 'API\AdminController@destroy_profile'); // Delete Profile
});

Route::post('login', 'API\UserController@login'); // login
Route::post('/getemail', 'API\SendEmailController@send'); // Send Email
Route::post('/newpassword', 'API\SendEmailController@newpassword'); // Get New Password






use App\User;
Route::get('test', function (Request $request){
   return response()->json(['test' => User::all()], 200);
}); // Test Route 

