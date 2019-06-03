<?php

namespace App\Http\Controllers\API;

use App\User;
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
}
