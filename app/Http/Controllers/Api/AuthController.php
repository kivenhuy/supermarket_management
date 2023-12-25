<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'phone_number' => 'required|string',
            'password' => 'required|string|min:5',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'result' => false,
                'message' => $validator->messages(),
            ]);
        }

        $credential = [
            'phone_number' => $request->input('phone_number'),
            'password' => $request->input('password'),
        ];

        if (auth()->attempt($credential)) {
            $user = User::where('phone_number',  $request->input('phone_number'))->first();
            if ($user) {
                return $this->loginSuccess($user);
            } 
            return response()->json([
                'result' => false,
                'message' => 'User is not exist',
            ]);
        } 
        
        return response()->json([
            'result' => false,
            'message' => 'The credentials did not match',
        ]);
    }

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|string',
            'username' => 'required|string',
            'password' => 'required|string|min:5',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'result' => false,
                'message' => $validator->messages(),
            ]);
        }

        $cooperative = new User();
        $cooperative->name = $request->username;
        $cooperative->user_type = 'coooperative';
        $cooperative->username = $request->username;
        $cooperative->email = $request->email;
        $cooperative->password = Hash::make($request->password);
        $cooperative->phone_number = $request->phone_number;
        $cooperative->email_verified_at = "";
        $cooperative->save();
        if ($cooperative) {
            return response()->json([
                'result' => true,
                'message' => 'Registration Success',
                'data'=>1
            ]);
        }else
        {
            return response()->json([
                'result' => false,
                'message' => 'Registration Failed',
                'data'=>0
            ]);
        }
    }

    public function loginSuccess($user, $token = null)
    {

        if (!$token) {
            $token = $user->createToken('Farm-angel API Token')->plainTextToken;
        }
        
        return response()->json([
            'result' => true,
            'message' => 'Successfully logged in',
            'data' =>[
                'user' => [
                    'id' => $user->id,
                    'type' => $user->user_type,
                    'name' => $user->name,
                    'email' => $user->email,
                    'phone' => $user->phone_number,
                ],
                'access_token' => $token,
                'token_type' => 'Bearer',
                'expires_at' => null,
            ]
        ]);
    }

    public function logout(Request $request)
    {
        $user = request()->user();
        $user->tokens()->where('id', $user->currentAccessToken()->id)->delete();

        return response()->json([
            'result' => true,
            'message' => 'Successfully logged out',
        ]);
    }

   
}
