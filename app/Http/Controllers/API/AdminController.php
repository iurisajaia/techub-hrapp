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
        return response()->json(['users' => User::all()]);
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



    // Create New Profile
    public function storeprofile(Request $request){

        $validator = Validator::make($request->all(), [ 
            'name' => 'required|string|max:60', 
            'lastname' => 'required|max:60',
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



    // Get All Profile
    public function viewprofiles(){
        $profiles = Profile::all();

        return response()->json(['profiles' => $profiles]);
    }


    // Single Profile
    public function singleprofile($id){
        $profile = Profile::find($id);

        if(!$profile){
            return response()->json('User Not Found');
        }

        return response()->json(['profile' => $profile]);
    }


    // Update Profile
    public function update_profile($id, Request $request){

        $profile = Profile::findOrFail($id);

        $validator = Validator::make($request->all(), [ 
            'name' => 'required|string|max:60', 
            'lastname' => 'required|max:60',
            'email' => 'required|email|max:255'
        ]);

        if ($validator->fails()) { 
                return response()->json(['error'=>$validator->errors()], 401);            
        }
        

        $profile->name = $request->name;
        $profile->lastname = $request->lastname;
        $profile->email = $request->email;
        $profile->facebook = $request->facebook;
        $profile->linkedin = $request->linkedin;
        $profile->save();


        return response()->json(['profile' => $profile]);
    }

    //Delete Profile
    public function destroy_profile($id){

        $profile = Profile::find($id);    
        $profile->delete();

        return response()->json(['user deleted']);
    }
}
