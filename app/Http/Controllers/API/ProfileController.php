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
    //     $profile = Profile::where('status', '=', 'draft')
    // ->orderByRaw("FIELD(status , 'open', 'announced', 'delayed', 'closed') ASC")
    // ->orderByRaw("IF(status = 'announced', accouncement_date, date_start) DESC")
    // ->get();
    if(auth()->user()->isManager()){
        $profile = Profile::with(['projects', 'technologies'])->orderByRaw("FIELD(status , 'shortlisted') DESC")->get()->makeHidden('salary');
        return response()->json(['profiles' => $profile]);
    }
    else {

        return response()->json(['profiles' => Profile::with(['projects', 'technologies'])->orderByRaw("FIELD(status , 'shortlisted') DESC")->get()]);
    }

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
            'name' => 'required|string|max:100',
            'position' => 'string',
            'profile' => 'string',
            'comment' => 'string',
            'salary' => 'string',
            'source' => 'string',
            'status' => 'string',
            'author_id' => 'integer'
        ]);

        if ($validator->fails()) { 
                return response()->json(['error'=>$validator->errors()], 400);            
        }

        $profile = Profile::create([
            'name' => $request->name,
            'phone' => $request->phone,
            'position' => $request->position,
            'profile' => $request->profile,
            'english' => $request->english,
            'salary' => $request->salary,
            'comment' => $request->comment,
            'source' => $request->source,
            'status' => $request->status,
            'author_id' =>  $request->author_id,
        ]);
        
        if($request->projects){
            $profile->projects()->attach($request->projects);
        }
        if($request->technologies){
            $profile->technologies()->attach($request->technologies);
        }
        
        return response()->json(['profile' => $profile , 'projects' => $profile->projects()->get() , 'technologies' => $profile->technologies()->get()]);
        
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
        
        return response()->json(['profile' => $profile , 'projects' => $profile->projects()->get() , 'technologies' => $profile->technologies()->get()]);
        
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
            'english' => 'required|string',
            'salary' => 'string',
            'comment' => 'required|string',
            'source' => 'required|string',
            'status' => 'required|string'
        ]);

        if ($validator->fails()) { 
                return response()->json(['error'=>$validator->errors()], 400);            
        }

        $profile->name = $request->name;
        $profile->phone = $request->phone;
        $profile->position = $request->position;
        $profile->profile = $request->profile;
        $profile->english = $request->english;
        $profile->salary = $request->salary;
        $profile->source = $request->source;
        $profile->status = $request->status;
        $profile->comment = $request->comment;
        $profile->updater_id = $request->updater_id;

        if($request->projects){
            $profile->projects()->sync($request->projects);
        }

        if($request->technologies){
            $profile->technologies()->sync($request->technologies);
        }
                
        

        $profile->save();

        return response()->json(['profile' => $profile , 'projects' => $profile->projects()->get() , 'technologies' => $profile->technologies()->get()]);
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

        return response()->json(['success' => 'user deleted'] , 200);
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
