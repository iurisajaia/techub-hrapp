<?php

namespace App\Http\Controllers\API;

use Validator;
use App\Profile;
use App\Project;
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
        
        return response()->json(['profiles' => Profile::with(['projects', 'technologies'])->get()]);
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
        // dd($request->all());
        $validator = Validator::make($request->all(), [ 
            'name' => 'required|string|max:100',
            'phone' => 'required|string|max:100|unique:profiles',
            'position' => 'required|string',
            'profile' => 'required|string',
            'comment' => 'required|string|max:255',
            'english' => 'required|string',
            'salary' => 'required|string',
            'source' => 'required|string',
            'status' => 'required|string'
        ]);

        if ($validator->fails()) { 
                return response()->json(['error'=>$validator->errors()], 401);            
        }

        $profile = Profile::create([
            'name' => $request->name,
            'phone' => $request->phone,
            'position' => $request->position,
            'profile' => $request->profile,
            'comment' => $request->comment,
            'english' => $request->english,
            'salary' => $request->salary,
            'source' => $request->source,
            'status' => $request->status
        ]);
        
        if($request->projects){
            $profile->projects()->attach($request->projects);
        }
        if($request->technologies){
            $profile->technologies()->attach($request->technologies);
        }
        
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
        
        return response()->json(['profile' => $profile , 'projects' => $profile->projects()->find(1)]);
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
            'name' => 'required|string|max:100',
            'phone' => 'required|string',
            'position' => 'required|string',
            'profile' => 'required|string',
            'comment' => 'required|string|max:255',
            'english' => 'required|string',
            'salary' => 'required|string',
            'source' => 'required|string',
            'status' => 'required|string'
        ]);

        if ($validator->fails()) { 
                return response()->json(['error'=>$validator->errors()], 401);            
        }

        $profile->name = $request->name;
        $profile->phone = $request->phone;
        $profile->position = $request->position;
        $profile->profile = $request->profile;
        $profile->english = $request->english;
        $profile->comment = $request->comment;
        $profile->salary = $request->salary;
        $profile->source = $request->source;
        $profile->status = $request->status;
        $profile->black_list = $request->black_list;

        if($request->projects){
            $profile->projects()->sync($request->projects);
        }

        if($request->technologies){
            $profile->technologies()->sync($request->technologies);
        }

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


    public function date($id){

        $dateNow = date('Y-m-d H:i:s');

        $profile = Profile::select("profiles.*")

            ->whereBetween('created_at', [$id, $dateNow])

            ->get();

        return response()->json(['profiles' => $profile]);
    }

    public function black(){
        $profiles = Profile::where('black_list', 1)
               ->get();


        return response()->json(['profiles' => $profiles]);
    }
}
