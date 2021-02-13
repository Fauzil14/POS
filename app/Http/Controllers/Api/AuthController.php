<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Http\Controllers\Controller;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Tymon\JWTAuth\Exceptions\JWTException;
use Illuminate\Auth\Notifications\VerifyEmail;

class AuthController extends Controller
{
    public function register(Request $request) {

        $validatedData = $request->validate([
            'name'     => [ 'required', 'string', 'max:100' ],
            'email'    => [
                            'required', 'email:rfc,dns', 'unique:users', 
                          ],
            'password' => [ 'required', 'min:8', 'confirmed' ],
        ]);
        
        $user = User::create([
            'name'      => $validatedData['name'],           
            'email'     => $validatedData['email'],           
            'password'  => Hash::make($validatedData['password']),           
        ]);

        $token = JWTAuth::fromUser($user);

        return response()->json(compact('user', 'token'), 201);
    }

    public function login(Request $request) {
        
        $user = User::firstWhere('email', $request->email);

        $credentials = $request->validate([
            'email'    => [ 'required', 'email', 'exists:users,email' ],
            'password' => [ 'required', function($attribute, $value, $fail) use ($request, $user) {                                           
                                            if( !empty($user) ) {
                                                if(!Hash::check($value, $user->password) ) {
                                                    $fail(__('Password is invalid'));
                                                }
                                            }
                                        }
                          ],
        ]);

        try {
            $token = JWTAuth::attempt($credentials);

            return response()->json(compact('user', 'token'));
        } catch (JWTException $e) {
            return response()->json(['error' => 'could_not_create_token'], 500);
        }

    }
}
