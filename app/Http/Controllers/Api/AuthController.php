<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Crypt;
use App\Http\Requests\changePasswordRequest;
use Illuminate\Validation\ValidationException;


class AuthController extends Controller
{
    public function login(Request $request){
        
        $username=$request->username;
        $password=$request->password;
        
        $login=User::where('username',$username)->get()->first();

        if (! $login || ! Hash::check($password, $login->password)) {
            throw ValidationException::withMessages([
                'message' => ['The provided credentials are incorrect.']
            ])->status(401);
        }
        $token = $login->createToken('myapptoken')->plainTextToken;
        $cookie = cookie('authcookie',$token);

        return response()->json([
            'data' => $login ,
            'message' => 'Successfully Logged In',
            'token' => $token
            
        ], 200)->withCookie($cookie);
        
    }

    public function resetPassword(Request $request, $id){
        $user = User::where('id', $id)->first();

        if (!$user) {
            return response()->json([
                'status_code' => "404",
                'message' => "User not found"
                ], 404);
        }
        
        $user->update([
            'password' => $user->username,
        ]);
        return response()->json(['message' => 'Password has been Reset!'], 200);
    }

    public function changedPassword(changePasswordRequest $request){

        $user = auth('sanctum')->user();
        
        if (! $user) {
            return response()->json(['message' => 'User not authenticated'], 401);
        }

        $user->update([
            'password' => Hash::make($request->new_password),
        ]);
    
        return response()->json(['message' => 'Password Successfully Changed!!'], 200);
    }
    
    public function Logout(Request $request){
        auth('sanctum')->user()->currentAccessToken()->delete();//logout currentAccessToken
        return response()->json(['message' => 'You are Successfully Logged Out!']);
    }


}
 