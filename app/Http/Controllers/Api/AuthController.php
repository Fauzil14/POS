<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Exceptions\JWTException;
use Illuminate\Auth\Notifications\VerifyEmail;

class AuthController extends Controller
{
    public function register(Request $request) {
        $validatedData = $request->validate([
            'name'     => [ 'required', 'string', 'max:100' ],
            'email'    => [
                            'required', 'email:rfc,dns', 'unique:users', 
                            // function($attribute, $value, $fail) {
                            // // $email
                            //     $email = filter_var($value, FILTER_SANITIZE_EMAIL);
                            //     $email = (boolean) filter_var($email, FILTER_VALIDATE_EMAIL); 
                            //     dd($email);
                            //     if( $email == true ) {
                            //         dd($value . " is a valid email address");
                            //     } else {
                            //         dd($value . " is not a valid email address");
                            //     };

                            //     if( filter_var($value, FILTER_VALIDATE_EMAIL) == FALSE ) {
                            //         $fail($attribute . " yang anda masukkan tidak valid !");
                            //     } 
                            // }
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
        $credentials = $request->only('email', 'password');

        try {
            if (! $token = JWTAuth::attempt($credentials)) {
                return response()->json(['error' => 'invalid_credentials'], 400);
            }
        } catch (JWTException $e) {
            return response()->json(['error' => 'could_not_create_token'], 500);
        }

        $user = User::firstWhere('email', $request->email);

        return response()->json(compact('user', 'token'));
    }
}
