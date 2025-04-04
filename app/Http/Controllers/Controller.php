<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use App\Models\User;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;


class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;
    public function create(){
      try{  $attribute = request()->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email',
            'password' => 'required|string|min:8',
            'role'     => 'required',
            'phone'    => 'required' ,
            'address'  => 'required',
        ]);

        $user = User::create([
            'name'     => request(  'name'    ),
            'email'    => request(  'email'   ),
            'password' => bcrypt(request(  'password')),
            'role'     => request(  'role'    ),
            'phone'    => request('phone'),
            'address'  => request('address'),
        ]);
   
        $token = $user->createToken('token')->plainTextToken;
        return response()->json(
            [
            'success'=> 'RegisterSuccesfuly',
            'message'=>'Registered',
            'token' => $token,
            ]
            ,200);}
      catch(\Exception $e){
        return response()->json(
            [
            'error'=> 'RegisterFailed',
            'message'=>$e->getMessage(),
            ]
            ,400);
            }
    }

    public function login() {
      try{
        $attribute = request()->validate([
            'email'    => 'required|email',
            'password' => 'required|string|min:8',
            
        ]); 
    

        $user = Auth()->attempt([
            'email' => request('email'),
            'password' =>request('password'),
        ]);
        if(!$user){
            return response()->json(
                [
                'error'=> 'LoginFailed',
                'message'=>'Invalid Email or Password',
                ]
                ,400);
        }else{
            $token = auth()->user()->createToken('token')->plainTextToken;
            return response()->json(
                [
                'success' => "LoginSuccessfully",
                'message' => 'Loged',
                'token' => $token
                ]
                ,200);
        }}
        catch(\Exception $e){
            return response()->json([
                'error'=>$e->getMessage(),
            ],300);
        }
   
    }


    public function googleAuth(Request $request)
    {
        try {
            $googleToken = $request->input('token');
            
            $googleUser = Http::get("https://www.googleapis.com/oauth2/v3/tokeninfo?id_token=$googleToken")->json();
            
            if (!isset($googleUser['email'])) {
                return response()->json(['message' => 'Invalid token'], 401);
            }
            
            $user = User::updateOrCreate(
                [
                    'email' => $googleUser['email'],
                    'name' => $googleUser['name'] ?? '',
                    'password' => bcrypt(uniqid()),
                ],
                
            );
            
            $token = $user->createToken('auth_token')->plainTextToken;
            
            return response()->json([
                'status' => true,
                'message' => 'User authenticated successfully',
                'user' => $user,
                'token' => $token
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Authentication failed',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
