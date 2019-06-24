<?php

    namespace App\Http\Controllers\API;

    use App\User; 
    use Validator;
    use Laravel\Passport\Passport;
    use Illuminate\Http\Request; 
    use App\Http\Controllers\Controller; 
    use Illuminate\Support\Facades\Auth; 

    class UserController extends Controller {

        
        public $successStatus = 200;


        /* login api */ 

        public function login(Request $request){ 
            
            if(!$request->email || !$request->password){
                return response()->json(['errors' => 'all fields are required']);
            }

            $user = User::where('email' , $request->email)->first();
            if(!$user){
                return response()->json(['errors' =>'email not found'], 401);
            }else{

                if(Auth::attempt(['email' => request('email'), 'password' => request('password')])){ 
                    $user = Auth::user(); 
                    if($request->keepMe){
                        Passport::personalAccessTokensExpireIn(now()->addDays(365));
                    }else{
                        Passport::personalAccessTokensExpireIn(now()->addHours(1));
                    }
                    $success['token'] =  $user->createToken('MyApp')-> accessToken; 

                    return response()->json(['success' => $success, 'user' => $user], $this-> successStatus); 
                }
                else{ 
                    return response()->json(['errors' =>'Incorrect Password' ], 401); 
                }
            }
        }
        

        /*  Register api */ 
        public function register(Request $request){ 
            $validator = Validator::make($request->all(), [ 
                'name' => 'required|string|max:60', 
                'email' => 'required|email|max:255', 
                'password' => 'required|min:8|max:32', 
                'c_password' => 'required|same:password', 
            ]);

            if ($validator->fails()) { 
                        return response()->json(['error'=>$validator->errors()], 401);            
                    }

            $exists = User::where('email', '=', $request->email)->first();
            if ($exists) {
                return response()->json(['error'=> 'Email Already Exists'], 401);            
            }

            $input = $request->all(); 
            $input['password'] = bcrypt($input['password']); 
            $user = User::create($input); 
            return response()->json(['user' => $user ], $this-> successStatus); 
        }


        public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $validator = Validator::make($request->all(), [ 
            'name' => 'required|string|max:60', 
            'email' => 'required|email|max:255'
        ]);

        if ($validator->fails()) { 
            return response()->json(['error'=>$validator->errors()], 401);            
        }      
        
        // dd($request->all());
        $user->name = $request->name;
        $user->email = $request->email;
        $user->role = $request->role;
        if($request->password){
            $validator = Validator::make($request->all(), [ 
                'password' => 'min:8|max:32', 
                'c_password' => 'same:password',
            ]);
            if ($validator->fails()) { 
                return response()->json(['error'=>$validator->errors()], 401);            
            }  
           $user->password = bcrypt($request->password);
        }
        $user->save();


        return response()->json(['user' => $user]);
    }


    public function destroy($id)
    {
        $user = User::find($id);    
        $user->delete();

        return response()->json(['success' => 'user deleted'] , 200);
    }

       
}