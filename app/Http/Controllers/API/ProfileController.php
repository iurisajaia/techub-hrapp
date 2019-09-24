<?php

namespace App\Http\Controllers\API;

use Validator;
use App\Profile;
use App\Project;
use App\SallaryModel;
use SoapClient;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use EloquentBuilder;
class ProfileController extends Controller{

    protected $client;
 
    public function __construct(){
        $this->client = new SoapClient('http://nbg.gov.ge/currency.wsdl');
    }


    // Filter Profiles By Advanced
    public function filter(Request $request){

        $name = $request->name;
        $phone = $request->phone;
        $position = $request->position;
        $english = $request->english;
        $salary = $request->salary;
        $source = $request->source;
        $status = $request->status;
        $projects = $request->projects;
        $technologies = $request->technologies;

        $value = $request->value;



        $reqArray = array("name"=>$name, "phone"=>$phone, "position"=>$position, "english"=>$english,"salary"=>$salary,"source"=> $source, "status"=> $status);

        $WithRelations = Profile::with(['projects' , 'technologies'])->get();

        if($value){
            $terms = explode(" ", $value);
            
            $ValueProfiles = Profile::query()
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
            ->get();

            $allProfile = array();

            foreach($ValueProfiles as $valp){
                foreach($WithRelations as $wrp){
                    if($valp->id == $wrp->id){
                        array_push($allProfile, $wrp);
                    }
                }
            }

            return response()->json(['profiles' => $allProfile]);

        }

        if($name || $phone || $position || $english || $salary || $source || $status){
            $AllProf = Profile::where(function ($query) use($reqArray) {
                foreach($reqArray as $key => $reqArr){
                    if($reqArr !== null){
                    $query->where($key, 'like', '%' . $reqArr . '%');
                }
            }
            })->get();
    
            
            $allProfiles = array();

            foreach($AllProf as $ap){
                foreach($WithRelations as $wr){
                    if($ap->id === $wr->id){
                        array_push($allProfiles , $wr);
                    }
                }
            }

        }else{
            $allProfiles = array();
        }

        $arr = array();
        
        if(!is_null($projects) || !is_null($technologies)){
            // Get Projects
            if(!empty($projects)){
                foreach($WithRelations as $key => $allProfile){
                    foreach($allProfile['projects'] as $allProfileProject){
                        foreach($projects as $project){
                            if($allProfileProject['id'] == $project['id']){
                                array_push($arr,$allProfile);
                            }
                        }
                    } 
                }
            }
            
            // Get Technologies
            if(!empty($technologies)){
                foreach($WithRelations as $allProfile){
                    foreach($allProfile['technologies'] as $allProfiletechnology){
                        foreach($technologies as $technology){
                            if($allProfiletechnology['id'] == $technology['id']){
                                array_push($arr,$allProfile);
                                
                            }
                        }
                    } 
                }
            }
            
        }
        
        $finalArray = array();
        
        if(!is_null($allProfiles)){
            foreach($allProfiles as $allprof){
                array_push($finalArray , $allprof);
            }
        }
        
        if(!empty($arr)){
            foreach($arr as $arrprof){
                array_push($finalArray , $arrprof);
            }
        }
        
        $uniQueArr = array_unique($finalArray);

        $finArr = array();

        foreach($uniQueArr as $ua){
            array_push($finArr , $ua);
        }


            return response()->json(['profiles' => $finArr]);

    }


    // Get Profiles
    public function index(){

        $allProfile = Profile::with(['projects', 'technologies'])->orderByRaw("FIELD(status , 'shortlisted') DESC")->paginate(100);
        

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
    
        // if(auth()->user()->isManager()){
        //     $profile = Profile::with(['projects', 'technologies'])->orderByRaw("FIELD(status , 'shortlisted') DESC")->get()->makeHidden(['salary' , 'net']);
        //     return response()->json(['profiles' => $profile]);
        // }
        // else {
            return response()->json(['profiles' => $allProfile ]);
        // }

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
