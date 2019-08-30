<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Validator;
use App\ClientPerson;

class ClientPersonController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $client_person = ClientPerson::with(['client' , 'person' , 'month'])->where('person_id' , 1)->get();
        return response()->json(['client_person' => $client_person]);
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
            'person_id' => 'required',
            'client_id' => 'required',
            'month_id' => 'required|max:2',
            'type' => 'required'
        ]);


        if ($validator->fails()) { 
                return response()->json(['error'=>$validator->errors()], 400);            
        }
        
        if($request->type){
            $clientperson = ClientPerson::create([
                'person_id' => $request->person_id,
                'client_id' => $request->client_id,
                'month_id' => $request->month_id,
                'type' => $request->type,
                'salary' => $request->salary
            ]);
        }else{
           
            $clientperson = ClientPerson::create([
                'person_id' => $request->person_id,
                'client_id' => $request->client_id,
                'month_id' => $request->month_id,
                'type' => $request->type,
                'cost' => $request->cost,
                'rate' => $request->rate,
                'sum' => $request->cost * $request->rate
            ]);
        }
        
        
        
        return response()->json(['client_person' => $clientperson]);
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
