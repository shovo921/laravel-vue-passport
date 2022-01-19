<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [

            'email' => 'required|email',
            'password' => 'required'
        ]);
        if ($validator->fails())
        {
            return send_error('validation error',$validator->errors(),'422');
        }
       $credisial= $request->only('email','password');
        if (Auth::attempt($credisial)){
            $user=Auth::user();
            $data['name']=$user->name;
            $data['access_token'] = $user->createToken('accessToken')->accessToken;
            return send_sucess('you are login ',$data,402);

        }
        else{
            return send_error('you are unauthorise','error',402);
        }

    }
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [

            'name' => 'required|min:2',
            'email' => 'required|unique:users',
            'password' => 'required'
        ]);
        if ($validator->fails())
         {
//            return response()->json([
//                'messege' => 'Validator error',
//                'error' => $validator->errors()
//
//            ], 422);
            return send_error('validation error',$validator->errors(),'422');
        }
        try{
            $data= User::create([
                'name'=> $request->name,
                'email'=> $request->email,
                'password'=>Hash::make($request->password)

            ]);
            if($data){

                return send_sucess('ok',$data);
            }
        }
        catch(Exception $e)
        {
//            return response()->json([
//                'messege'=> $e->getMessage()
//            ],$e->getCode());
             return send_error($e->getMessage(),'',$e->getCode());
        }

    }
}
