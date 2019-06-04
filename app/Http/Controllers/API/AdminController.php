<?php

namespace App\Http\Controllers\API;

use App\User;
use App\Profile;
use Validator;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AdminController extends Controller
{
    public function users(){
        return response()->json(['users' => User::all()]);
    }
    
    public function makemanager($id){
        $user = User::find($id);
        $user->role = 'manager';
        $user->save();
        return response()->json(['user' => $user]);
    }

    public function makeviewer($id){
        $user = User::find($id);
        $user->role = 'viewer';
        $user->save();
        return response()->json(['user' => $user]);
    }


    public function createprofile(Request $request){

        $validator = Validator::make($request->all(), [ 
            'name' => 'required|string|max:60', 
            'lastname' => 'required|min:8|max:60',
            'email' => 'required|email|max:255'
        ]);

        if ($validator->fails()) { 
                return response()->json(['error'=>$validator->errors()], 401);            
        }

        $profile = Profile::create([
            'name' => $request->name,
            'lastname' => $request->lastname,
            'email' => $request->email,
            'facebook' => $request->facebook,
            'linkedin' => $request->linkedin,
        ]);

        return response()->json(['profile' => $profile]);
    }

    public function viewprofiles(){
        $profiles = Profile::all();

        return response()->json(['profiles' => $profiles]);
    }
}
