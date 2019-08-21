<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Project;
use App\Profile;
use Validator;
class ProjectsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // $profile = Profile::with(['projects', 'technologies'])->orderByRaw("FIELD(status , 'shortlisted') DESC")->get()->makeHidden('salary');
        $project =  Project::with('profiles')->orderBy('order', 'ASC')->get();
        return response()->json(['projects' => $project]); 
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
            'title' => 'required|string|unique:projects',
            'author_id' => 'required|integer',
        ]);

        if ($validator->fails()) { 
                return response()->json(['error'=>$validator->errors()], 400);            
        }

        
        

        $project = Project::create([
            'title' => $request->title,
            'author_id' => $request->author_id,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'status' => $request->status,
            'referral' => $request->referral,
            'comment' => $request->comment,
            'order' => $request->order
        ]);

        return response()->json(['project' => $project]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $project = project::find($id);
        $profiles = Profile::with(['projects', 'technologies'])->get();
        $finalProfiles = [];
        foreach($profiles as $profile){
            foreach($profile->projects as $p){
                if($p->id == $id){
                    $prof = $p->pivot->profile_id;
                    $final = Profile::with(['projects', 'technologies'])->where('id', $prof)->get();
                    array_push($finalProfiles, $final);
                }
            }
        }


        if(!$project){
            return response()->json(['error' => 'Project Not Found'] , 400);
        }
        
        return response()->json(['project' => $project , 'profiles' => $finalProfiles]);
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
        $project = Project::findOrFail($id);

        $validator = Validator::make($request->all(), [ 
            'title' => 'required|string'
        ]);

        if ($validator->fails()) { 
                return response()->json(['error'=>$validator->errors()], 400);            
        }      
        
        $project->title = $request->title;
        $project->start_date = $request->start_date;
        $project->end_date = $request->end_date;
        $project->status = $request->status;
        $project->referral = $request->referral;
        $project->updater_id = $request->updater_id;
        $project->comment = $request->comment;
        $project->order = $request->order;

        $project->save();


        return response()->json(['project' => $project]);
    }
    

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $project = Project::find($id);    
        $project->delete();

        return response()->json(['success' => 'Project Deleted']);
    }

    public function order(Request $request){
        $orders = $request->order;
        // $projects = Project::all();

        foreach ($orders as $key => $id) {
           $project = project::find($id);
           $project->order = $key;
           $project->save();
        }
   
        $updatedProject =  Project::with('profiles')->orderBy('order', 'ASC')->get();
        return response()->json(['success' => $updatedProject]);
    }
}


