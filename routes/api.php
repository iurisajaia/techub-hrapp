<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
*/


Route::middleware(['auth:api' , 'admin'])->group(function (){ // Only For Admin 
    // User Managment
    Route::get('/users', 'API\AdminController@users'); // Get All User
    Route::post('register', 'API\UserController@register'); // Add New User
    Route::put('update-user/{id}', 'API\UserController@update'); // Update User
    Route::post('makemanager/{id}', 'API\AdminController@makemanager'); // Change User Role To Manager
    Route::post('makeviewer/{id}', 'API\AdminController@makeviewer'); // Change User Role To Viewer
    
    // Profile Managment
    Route::post('store-profile', 'API\ProfileController@store'); // Create Profile
    Route::get('all-profiles', 'API\ProfileController@index'); // Get All Profile
    Route::get('profile/{id}', 'API\ProfileController@show'); // Single Profile View
    Route::put('update-profile/{id}', 'API\ProfileController@update'); // Update Profile
    Route::delete('destroy-profile/{id}', 'API\ProfileController@destroy'); // Delete Profile
    Route::get('get-profile/date/{date}' , 'API\ProfileController@date'); // Get Profiles With Date
    Route::get('get-black-list' , 'API\ProfileController@black'); // Get Black List
    
    // Projects
    Route::get('get-projects', 'API\ProjectsController@index'); // Get Projects
    Route::post('store-project', 'API\ProjectsController@store'); // Store Project
    Route::get('project/{id}', 'API\ProjectsController@show'); // Single Project View
    Route::put('update-project/{id}', 'API\ProjectsController@update'); // Update Project
    Route::delete('destroy-project/{id}', 'API\ProjectsController@destroy'); // Delete Project
    
    
    // Technologies
    Route::get('get-technologies', 'API\TechnologyController@index'); // Get Technology
    Route::post('store-technology', 'API\TechnologyController@store'); // Store Technology
    Route::get('technology/{id}', 'API\TechnologyController@show'); // Single Technology View
    Route::put('update-technology/{id}', 'API\TechnologyController@update'); // Update Technology
    Route::delete('destroy-technology/{id}', 'API\TechnologyController@destroy'); // Delete Technology
});



// Visitor Routes
Route::post('login', 'API\UserController@login'); // login
Route::post('/getemail', 'API\SendEmailController@send'); // Send Email
Route::post('/newpassword', 'API\SendEmailController@newpassword'); // Get New Password






use App\User;
Route::get('test', function (Request $request){
   return response()->json(['test' => User::all()], 200);
}); // Test Route 

