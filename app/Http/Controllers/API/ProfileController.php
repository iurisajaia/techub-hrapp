<?php

namespace App\Http\Controllers\API;

use Validator;
use App\Profile;
use App\Project;
use App\SallaryModel;
use SoapClient;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ProfileController extends Controller{

    protected $client;
 
    public function __construct(){
        $this->client = new SoapClient('http://nbg.gov.ge/currency.wsdl');
    }


    // Filter Profiles By Advanced Filter
    public function filter($name= null , $phone= null ,$position= null ,  $english= null , $salary= null ,$source = null , $status = null){

        if($name || $phone || $position || $english || $salary || $source || $status){
        
            $allProfile = Profile::query()
            ->where('name', 'LIKE', '%'.$name.'%')
            ->where('phone', 'LIKE', '%'.$phone.'%')
            ->where('position', 'LIKE', '%'.$position.'%')
            ->where('english', 'LIKE', '%'.$english.'%')
            ->where('salary', 'LIKE', '%'.$salary.'%')
            ->where('source', 'LIKE', '%'.$source.'%')
            ->where('status', 'LIKE', '%'.$status.'%')
            ->paginate(10);
        }

        $usd = $this->client->GetCurrency('USD');
            $index = SallaryModel::all();
            foreach($allProfile as $profile){
            $intSallary = (int)$profile->salary;
                if($intSallary > 0) {
                    $sallary = round((($intSallary/0.784)/(float)$usd) + $index[0]->index);
                }else{
                    $sallary = 0;
                }
                if($sallary){
                    $profile['net'] = $sallary;
                }
            }
    
        if(auth()->user()->isManager()){
            $profile = Profile::with(['projects', 'technologies'])->orderByRaw("FIELD(status , 'shortlisted') DESC")->get()->makeHidden(['salary' , 'net']);
            return response()->json(['profiles' => $profile]);
        }
        else {
            return response()->json(['profiles' => $allProfile ]);
        }


    }


    // Get Profiles
    public function index($value = null ){

        if($value){
                $terms = explode(" ", $value);
                
                
                $allProfile = Profile::query()
                ->whereHas('projects', function ($query) use ($terms) {
                    foreach ($terms as $term) {
                        // Loop over the terms and do a search for each.
                        $query->where('title', 'like', '%' . $term . '%');
                    }
                })
                ->orWhere(function ($query) use ($terms) {
                    foreach ($terms as $term) {
                        $query->where('name', 'like', '%' . $term . '%');
                    }
                })
                ->orWhere(function ($query) use ($terms) {
                    foreach ($terms as $term) {
                        $query->where('phone', 'like', '%' . $term . '%');
                    }
                })
                ->orWhere(function ($query) use ($terms) {
                    foreach ($terms as $term) {
                        $query->where('position', 'like', '%' . $term  . '%');
                    }
                })
                ->orWhere(function ($query) use ($terms) {
                    foreach ($terms as $term) {
                        $query->where('english', 'like', '%' . $term  . '%');
                    }
                })
                ->orWhere(function ($query) use ($terms) {
                    foreach ($terms as $term) {
                        $query->where('salary', 'like', '%' . $term  . '%');
                    }
                })
                ->orWhere(function ($query) use ($terms) {
                    foreach ($terms as $term) {
                        $query->where('source', 'like', '%' . $term  . '%');
                    }
                })
                ->orWhere(function ($query) use ($terms) {
                    foreach ($terms as $term) {
                        $query->where('status', 'like', '%' . $term  . '%');
                    }
                })
                ->paginate(100);
        }
        else{
        $allProfile = Profile::with(['projects', 'technologies'])->orderByRaw("FIELD(status , 'shortlisted') DESC")->paginate(100);
        }

        $usd = $this->client->GetCurrency('USD');
        $index = SallaryModel::all();
        foreach($allProfile as $profile){
        $intSallary = (int)$profile->salary;
            if($intSallary > 0) {
                $sallary = round((($intSallary/0.784)/(float)$usd) + $index[0]->index);
            }else{
                $sallary = 0;
            }
            if($sallary){
                $profile['net'] = $sallary;
            }
        }
    
        if(auth()->user()->isManager()){
            $profile = Profile::with(['projects', 'technologies'])->orderByRaw("FIELD(status , 'shortlisted') DESC")->get()->makeHidden(['salary' , 'net']);
            return response()->json(['profiles' => $profile]);
        }
        else {
            return response()->json(['profiles' => $allProfile ]);
        }

    }

    // Add New Profile
    public function store(Request $request){

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
            'portfolio' => $request->portfolio,
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
    
    // Get Single Profile
    public function show($id){
        $profile = Profile::find($id);

        $usd = $this->client->GetCurrency('USD');
        $index = SallaryModel::all();
        
        $intSallary = (int)$profile->salary;
        if($intSallary > 0) {
            $sallary = round((($intSallary/0.784)/(float)$usd) + $index[0]->index);
        }else{
            $sallary = 0;
        }
        if($sallary){
            $profile['net'] = $sallary;
        }

        if(!$profile){
            return response()->json('User Not Found');
        }
        
        return response()->json(['profile' => $profile , 'projects' => $profile->projects()->get() , 'technologies' => $profile->technologies()->get()]);
        
    }

    // Update Profile
    public function update(Request $request, $id){

        $profile = Profile::findOrFail($id);

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


        $profile->name = $request->name;
        $profile->phone = $request->phone;
        $profile->position = $request->position;
        $profile->portfolio = $request->portfolio;
        $profile->profile = $request->profile;
        $profile->english = $request->english;
        $profile->salary = $request->salary;
        $profile->source = $request->source;
        $profile->status = $request->status;
        $profile->comment = $request->comment;
        $profile->updater_id = $request->updater_id;
        $profile->feedback = $request->feedback;

        if($request->projects){
            $profile->projects()->sync($request->projects);
        }

        if($request->technologies){
            $profile->technologies()->sync($request->technologies);
        }
                
        

        $profile->save();


        $projects = $profile->projects()->get();
        $technologies = $profile->technologies()->get();

        $profile->projects = $projects;
        $profile->technologies = $technologies;
        
        return response()->json(['profile' => $profile]);
    }

    // Delete Profile
    public function destroy($id){
        $profile = Profile::find($id);    
        $profile->delete();

        return response()->json(['success' => 'user deleted'] , 200);
    }

    // Filter By Date
    public function date($id){

        $dateNow = date('Y-m-d H:i:s');

        $profile = Profile::select("profiles.*")

            ->whereBetween('created_at', [$id, $dateNow])

            ->get();

        return response()->json(['profiles' => $profile]);
    }


    // Add Profile To Black List
    public function black(){
        $profiles = Profile::where('black_list', 1)
               ->get();


        return response()->json(['profiles' => $profiles]);
    }
}
