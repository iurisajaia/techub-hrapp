<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
*/


Route::middleware(['auth:api' , 'ManagerOrAdmin' ])->group(function (){ // Only For Admin or Manager
    // User Managment
    Route::post('register', 'API\UserController@register'); // Add New User
    Route::put('update-user/{id}', 'API\UserController@update'); // Update User
    Route::delete('destroy-user/{id}', 'API\UserController@destroy'); // Delete User
    Route::post('makemanager/{id}', 'API\AdminController@makemanager'); // Change User Role To Manager
    Route::post('makeviewer/{id}', 'API\AdminController@makeviewer'); // Change User Role To Viewer
    
    // Profile Managment
    Route::post('store-profile', 'API\ProfileController@store'); // Create Profile
    Route::put('update-profile/{id}', 'API\ProfileController@update'); // Update Profile
    Route::delete('destroy-profile/{id}', 'API\ProfileController@destroy'); // Delete Profile
    
    // Projects
    Route::post('store-project', 'API\ProjectsController@store'); // Store Project
    Route::put('update-project/{id}', 'API\ProjectsController@update'); // Update Project
    Route::delete('destroy-project/{id}', 'API\ProjectsController@destroy'); // Delete Project
    
    // Technologies
    Route::post('store-technology', 'API\TechnologyController@store'); // Store Technology
    Route::put('update-technology/{id}', 'API\TechnologyController@update'); // Update Technology
    Route::delete('destroy-technology/{id}', 'API\TechnologyController@destroy'); // Delete Technology
    
    // Comments
    Route::post('store-comment', 'API\CommentsController@store'); // Store Comments
    
    Route::post('store-file', 'API\UploadsController@store'); // Add New File
});


Route::middleware(['auth:api' , 'user' ])->group(function (){ // Only For Admin 
    // User Managment
    Route::get('/users', 'API\AdminController@users'); // Get All User
    
    Route::get('/get-files', 'API\UploadsController@index'); // Get All Files
    Route::get('file/{id}', 'API\UploadsController@show'); // Single File

    
    // Profile Managment
    Route::get('all-profiles', 'API\ProfileController@index'); // Get All Profile
    Route::get('profile/{id}', 'API\ProfileController@show'); // Single Profile View
    Route::get('get-profile/date/{date}' , 'API\ProfileController@date'); // Get Profiles With Date
    Route::get('get-black-list' , 'API\ProfileController@black'); // Get Black List
    
    // Projects
    Route::get('get-projects', 'API\ProjectsController@index'); // Get Projects
    Route::get('project/{id}', 'API\ProjectsController@show'); // Single Project View
    
    // Technologies
    Route::get('get-technologies', 'API\TechnologyController@index'); // Get Technology
    Route::get('technology/{id}', 'API\TechnologyController@show'); // Single Technology View
    
    // Comments
    Route::get('get-comments', 'API\CommentsController@index'); // Get Technology


    
});



// Visitor Routes
Route::post('login', 'API\UserController@login'); // login
Route::post('/getemail', 'API\SendEmailController@send'); // Send Email
Route::post('/newpassword', 'API\SendEmailController@newpassword'); // Get New Password






use App\User;
Route::get('test', function (Request $request){
   return response()->json(['test' => User::all()], 200);
}); // Test Route 

