<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Technology;
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
            'title' => 'required|string',
            'author_id' => 'required|integer'
        ]);

        if ($validator->fails()) { 
                return response()->json(['error'=>$validator->errors()], 401);            
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
        //
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
                return response()->json(['error'=>$validator->errors()], 401);            
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
