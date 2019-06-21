<?php

namespace App\Http\Controllers\API;

use App\User;
use App\Profile;
use Validator;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AdminController extends Controller
{   

    // Get All Users
    public function users(){
        return response()->json(['users' => User::all()->toArray()]);
    }
    
    // Change User Role To Manager
    public function makemanager($id){
        $user = User::find($id);
        $user->role = 'manager';
        $user->save();
        return response()->json(['user' => $user]);
    }


    // Change User Role To Viewer
    public function makeviewer($id){
        $user = User::find($id);
        $user->role = 'viewer';
        $user->save();
        return response()->json(['user' => $user]);
    }
    
   
}
