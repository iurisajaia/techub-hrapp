<?php

namespace App\Http\Controllers\API;

use Validator;
use App\Profile;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $profiles = Profile::all();

        return response()->json(['profiles' => $profiles]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
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

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $profile = Profile::find($id);

        if(!$profile){
            return response()->json('User Not Found');
        }

        return response()->json(['profile' => $profile]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
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

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $profile = Profile::find($id);    
        $profile->delete();

        return response()->json(['user deleted']);
    }
}
