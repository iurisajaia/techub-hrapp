<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
use App\Mail\SendMail;
use App\User;
class SendEmailController extends Controller
{
    function send(Request $request){
        
       $this->validate($request, [
            'email' => 'required'
        ]);

       
        $user = User::where('email', $request->email) -> first(); 
        $success =  $user->createToken('MyApp')-> accessToken; 


        $data = array(
            'email' => $request->email,
            'name' => $user->name,
            'token' => $success
        );         

        
        
        Mail::to($request->email)->send(new SendMail($data));

        return response()->json('success', $data);
    }


    function newpassword(Request $request){
        $this->validate($request, [
            'email' => 'required',
            'newpass' => 'required|min:8',
            'c_newpass' => 'required|same:newpass'
        ]);

        $user = User::where('email', $request->email) -> first(); 
        $user->password = bcrypt($request->newpass);
        $user->save();
        return response()->json('password updated!');
    }
}
