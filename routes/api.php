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
    Route::post('projects-order', 'API\ProjectsController@order'); // Store Project
    Route::put('update-project/{id}', 'API\ProjectsController@update'); // Update Project
    Route::delete('destroy-project/{id}', 'API\ProjectsController@destroy'); // Delete Project
    
    // Technologies
    Route::post('store-technology', 'API\TechnologyController@store'); // Store Technology
    Route::put('update-technology/{id}', 'API\TechnologyController@update'); // Update Technology
    Route::delete('destroy-technology/{id}', 'API\TechnologyController@destroy'); // Delete Technology
    
    // Comments
    Route::post('store-comment', 'API\CommentsController@store'); // Store Comments
    
    Route::post('store-file', 'API\UploadsController@store'); // Add New File
    Route::post('store-excel', 'API\UploadsController@storeExcel'); // Add Data
    Route::delete('destroy-file/{id}', 'API\UploadsController@destroy'); // Delete Technology
    
    // Sallary index
    Route::post('store-index', 'API\SallaryController@store'); // Add New Index
    Route::put('update-index/{id}', 'API\SallaryController@update'); // Add New Index
    
    

    // Person
    Route::post('new-person', 'API\PersonController@store'); // Add New Person
    



    // Position
    Route::post('new-position', 'API\PositionController@store'); // Add New Position



    // Month
    Route::post('new-month', 'API\MonthController@store'); // Add New Month

    
    
    
    // Client
    Route::post('new-client', 'API\ClientController@store'); // Add New Client





    // Client_Person
    Route::post('new-cp', 'API\ClientPersonController@store'); // Add New Client_Person
});


Route::middleware(['auth:api' , 'user' ])->group(function (){ // Only For Admin 
    // User Managment
    Route::get('/users', 'API\AdminController@users'); // Get All User
    
    Route::get('/get-files', 'API\UploadsController@index'); // Get All Files
    Route::get('file/{id}', 'API\UploadsController@show'); // Single File

    
    // Profile Managment
    Route::get('all-profiles', 'API\ProfileController@index'); // Get All Profile
    Route::post('filter-profiles', 'API\ProfileController@filter'); // Get All Profile
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



    Route::get('get-sallary', 'API\SallaryController@index'); // Get Sallary


    // Position
    Route::get('get-positions', 'API\PositionController@index'); // Get Positions


    // Month
    Route::get('get-months', 'API\MonthController@index'); // Get Month


    // Client
    Route::get('get-clients', 'API\ClientController@index'); // Get Clients
    Route::get('get-client/{id}', 'API\ClientController@show'); // Get Client


    // Person
    Route::get('get-persons', 'API\PersonController@index'); // Get Persons
    Route::get('get-person/{id}', 'API\PersonController@show'); // Get Person


    // Client Person
    Route::get('get-cps', 'API\ClientPersonController@index'); // Get Client Persons
    
});



// Visitor Routes
Route::post('login', 'API\UserController@login'); // login
Route::post('/getemail', 'API\SendEmailController@send'); // Send Email
Route::post('/newpassword', 'API\SendEmailController@newpassword'); // Get New Password








