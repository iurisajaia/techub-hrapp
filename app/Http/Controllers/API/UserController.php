<?php

    namespace App\Http\Controllers\API;

    use App\User; 
    use Validator;
    use Illuminate\Http\Request; 
    use App\Http\Controllers\Controller; 
    use Illuminate\Support\Facades\Auth; 

    class UserController extends Controller {

        
        public $successStatus = 200;


        /* login api */ 

        public function login(){ 
          
            if(Auth::attempt(['email' => request('email'), 'password' => request('password')])){ 
                $user = Auth::user(); 
                $success['token'] =  $user->createToken('MyApp')-> accessToken; 
                return response()->json(['success' => $success, 'user' => $user], $this-> successStatus); 
            }
            else{ 
                return response()->json(['error'=>'Incorrect Data'], 401); 
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

            $input = $request->all(); 
            $input['password'] = bcrypt($input['password']); 
            $user = User::create($input); 
            $success['token'] =  $user->createToken('MyApp')-> accessToken; 
            $success['name'] =  $user->name;
            return response()->json(['success'=>$success], $this-> successStatus); 
        }

       
}