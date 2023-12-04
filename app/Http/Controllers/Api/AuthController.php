<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Crypt;
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
        $cookie =cookie('authcookie',$token);

        return response()->json([
            'message' => 'Successfully Logged In',
            'token' => $token
            
        ], 200)->withCookie($cookie);
        
    }

    //optional
    public function resetPassword(Request $request, $id){
        $user = User::where('id', $id)->first();
        $username = $user->username;
        $pass_encrypt = Crypt::encryptString($username);
        $user->update([
            'password' => $pass_encrypt
        ]);
        return response()->json(['message' => 'Password has been Reset!'], 200);
    }

    //optional not working pa
    public function changedPassword(Request $request){
        $old_password = $request->old_password;
        $new_password = $request->new_password;
        $auth_id = auth('sanctum')->user()->id;
        $user = User::where('id', $auth_id)->first();
        $decryptedPassword = Crypt::decryptString($user->password);
        if($old_password != $decryptedPassword){
            return response()->json(['message' => 'Password not match!!'], 422);
        }
        $encrypted_new_password = Crypt::encryptString($new_password);
        $user->update([
            'password' => $encrypted_new_password
        ]);
        return response()->json(['message' => 'Password Successfully Changed!!'], 200);
    }

    public function logout(Request $request){
        auth('sanctum')->user()->currentAccessToken()->delete(); 
        return response()->json(['message' => 'You are Successfully Logged Out!'], 200);
    }


}
 