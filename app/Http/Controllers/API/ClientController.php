<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Validator;
use App\Client;
use App\ClientPerson;

class ClientController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $clients = Client::with(['clientpersons', 'persons'])->get();
        // $client_person = ClientPerson::with(['client' , 'person' , 'month'])->get();
        return response()->json(['clients' => $clients]);
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
            'contact_person' => 'required|string',
            'number' => 'required|string',
            'end_date' => 'required|string',
            'start_date' => 'required|string'
        ]);


        if ($validator->fails()) { 
                return response()->json(['error'=>$validator->errors()], 400);            
        }
        
        $client = Client::create([
            'name' => $request->name,
            'contact_person' => $request->contact_person,
            'number' => $request->number,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date
        ]);

        if($request->person){
            $client->persons()->attach($request->person);
        }
        
        
        
        return response()->json(['client' => $client]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $client = Client::where('id', $id)->with(['clientpersons','persons'])->first();

        foreach($client->clientpersons as $cp){
            foreach($client->persons as $person){
                if($cp->person_id == $person->id){
                    $cp->person == $person;
                }
            }
        }
        
        if(!$client){
            return response()->json('Client Not Found');
        }
        
        return response()->json(['client' => $client]);
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
