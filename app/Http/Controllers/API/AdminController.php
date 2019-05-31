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

    public function makemodarator(Request $request){
        return response()->json(['user_id', $request=>all()]);
    }
}
