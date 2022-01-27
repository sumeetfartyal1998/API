<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class JwTCntroller extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api',['except'=>['login','register']]);
    }

    public function register(Request $req){
        $validator=Validator::make($req->all(),[
            'name'=>'required|string',
            'email'=>'required|string|email|unique:users',
            'password'=>'required|string|min:8'
        ]);
        if($validator->fails()){
            return response()->json($validator->errors());
        }
        else{
            $user=User::create([
                'name'=>$req->name,
                'email'=>$req->email,
                'password'=>Hash::make($req->password)    
            ]);
            return response()->json([
                'message'=>'User Created',
                'user'=>$user
            ],201);
        }
    }

    public function login(Request $req){
        $validator=Validator::make($req->all(),[
            'email'=>'required|string|email',
            'password'=>'required|string|min:8'
        ]);
        if($validator->fails()){
            return response()->json($validator->errors());
        }
        else{
           if(!$token=auth()->attempt($validator->validated())){
               return response()->json(['error'=>'Unauthorized !!'],401);
           }
           return $this->respondWithToken($token);
        }
    }

    public function logout(){
        auth()->logout();
        return response()->json(["message"=>"User Logout Successfully"]);
    }

    public function respondWithToken($token){
        return response()->json([
            'access_token'=>$token,
            'token_type'=>'bearer',
            'expires_in'=>auth()->factory()->getTTL()*60
        ]);
    }

    public function profile(){
        return response()->json(auth()->user());
    }

    public function refresh(){
        return $this->respondWithToken(auth()->refresh());
    }
}
