<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Technology;
use App\Profile;
use Validator;
class TechnologyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {   
        return response()->json(['technologies' => Technology::with('profiles')->get()]);
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
            'title' => 'required|string|unique:technologies',
            'author_id' => 'required|integer'
        ]);

        if ($validator->fails()) { 
                return response()->json(['error'=>$validator->errors()], 400);            
        }

        // dd($request->all());
        $technology = Technology::create([
            'title' => $request->title,
            'author_id' => $request->author_id
        ]);

        return response()->json(['technology' => $technology]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $technology = Technology::find($id);
        $profiles = Profile::with(['projects', 'technologies'])->get();
        $finalProfiles = [];
        foreach($profiles as $profile){
            foreach($profile->technologies as $p){
                if($p->id == $id){
                    $prof = $p->pivot->profile_id;
                    $final = Profile::with(['projects', 'technologies'])->where('id', $prof)->get();
                    array_push($finalProfiles, $final);
                }
            }
        }

        if(!$technology){
            return response()->json(['error' => 'Technology Not Found'] , 400);
        }
        
        return response()->json(['technology' => $technology , 'profiles' => $finalProfiles]);
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
        $technology = Technology::findOrFail($id);

        $validator = Validator::make($request->all(), [ 
            'title' => 'required|string'
        ]);

        if ($validator->fails()) { 
                return response()->json(['error'=>$validator->errors()], 400);            
        }      
        
        $technology->title = $request->title;
        $technology->updater_id = $request->updater_id;
        $technology->save();


        return response()->json(['technology' => $technology]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $technology = Technology::find($id);    
        $technology->delete();

        return response()->json(['success' => 'technology Deleted']);
    }
}
