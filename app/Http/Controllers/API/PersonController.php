<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Person;
use Validator;
class PersonController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $persons = Person::with(['positions','clientpersons','clients'])->get();
        return response()->json(['persons' => $persons]);
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
            'c_date' => 'required|string'
        ]);


        if ($validator->fails()) { 
                return response()->json(['error'=>$validator->errors()], 400);            
        }
        
        $person = Person::create([
            'name' => $request->name,
            'c_date' => $request->c_date
        ]);

        if($request->client){
            $person->clients()->attach($request->client);
        }
        
        
        
        return response()->json(['person' => $person]);
        
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        
        $person = Person::where('id', $id)->with(['positions','clientpersons','clients'])->first();

        if(!$person){
            return response()->json('Person Not Found');
        }
        
        return response()->json(['person' => $person]);
        
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
