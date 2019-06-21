<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use \Illuminate\Support\Facades\Auth;
use Validator;
use App\User;

class AuthController extends Controller
{
    public function login(Request $request){
        $validator = Validator::make($request->all(),['email'=>'required|exists:users,email','password'=>'required']);
        if($validator->fails()){
            return response()->json([
                'result'=>false,
                'message'=>'User Not Found'
            ]);
        }
        if(Auth::attempt(['email'=>$request->email,'password'=>$request->password])){
            $user = Auth::user();

            return response()->json([
                'result'=>true,
                'user_id'=>$user->getKey(),
                'name'=>$user->name,
                'mobile_no'=>$user->mobile_no,
                'token'=>$user->createToken('SalesApp')->accessToken
            ]);

        }else{
            return response()->json([
                'result'=>false,
                'message'=>'Password incorrect'
            ]);
        }

        
    }
}
