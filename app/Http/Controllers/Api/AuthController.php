<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Crypt;
use Tymon\JWTAuth\Exceptions\JWTException;
use function PHPUnit\Framework\throwException;

use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Validation\ValidationException;

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
            'password'  => $validatedData['password'],           
        ]);

        $token = JWTAuth::fromUser($user);

        return response()->json(compact('user', 'token'), 201);
    }

    public function login(Request $request) {
        
        $credentials = $request->validate([
            'email'    => [ 'required', 'email', 'exists:users,email' ],
            'password' => [ 'required', ],
        ]);

        if( Auth::attempt(['email' => $credentials['email'], 'password' => $credentials['password']])) {
            try {
                $token = JWTAuth::attempt($credentials);
                $user = new UserResource(User::firstWhere('email', $credentials['email']));

                return response()->json(compact('user', 'token'));
            } catch (JWTException $e) {
                return response()->json(['error' => 'could_not_create_token'], 500);
            }
        } else {
            throw ValidationException::withMessages(['password' => 'Password yang anda masukkan salah !']);
        }

    }
}
