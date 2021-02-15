<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;

class ProfileController extends Controller
{

    public function getAuthenticatedUser()
    {
        try {

            if (! $user = JWTAuth::parseToken()->authenticate()) {
                return response()->json(['user_not_found'], 404);
            }

        } catch (TokenExpiredException $e) {

            return response()->json(['token_expired']);

        } catch (TokenInvalidException $e) {

            return response()->json(['token_invalid']);

        } catch (JWTException $e) {

            return response()->json(['token_absent']);
        }
        
        return $this->sendResponse('succes', 'User data succesfully obtained', $user, 200);
    }

    public function updateProfile(Request $request) 
    {
        $authUser = User::find(Auth::id());

        $validatedData = $request->validate([
            'name'            => [ 'sometimes', 'string' ],
            'email'           => [ 'sometimes', 'email:rfc,dns', Rule::unique('users')->ignore($authUser->id) ],
            'umur'            => [ 'sometimes', 'integer' ],
            'alamat'          => [ 'sometimes', 'string' ],
            'profile_picture' => [ 'sometimes', 'image', 'max:2048', 'mimes:jpg,jpeg,png' ],
        ]);

        if(!empty($validatedData['profile_picture'])) {
            $pp = $this->uploadImage($validatedData['profile_picture']);
        } else {
            $pp = $authUser->profile_picture;
        }

        // forget = The forget method removes an item from the collection by its key
        $request = collect($validatedData)->forget('profile_picture');
    
        try {

            $request->each(function($item, $key) use ($authUser) {
                $authUser->{$key} = $item;
            });
            $authUser->profile_picture = $pp;
            $authUser->update();

            return $this->sendResponse('succes', 'User data has been succesfully updated', $authUser, 200);
        } catch(\Throwable $e) {

            return $this->sendResponse('failed', 'User data failed to update', $e->getMessage(), 500);
        }
    }

    public function changePassword(Request $request) {

        $validatedData = $request->validate([
            'password'          => [ 'required', 'password:api' ],
            'new_password'      => [ 'required', 'min:8', 'confirmed', 'different:password' ],
        ]);

        $user = User::findOrFail(Auth::id());

        try {
            $user->password = Hash::make($validatedData['new_password']);
            $user->save();

            return $this->sendResponse('succes', 'Your password has been change', true, 200);
        } catch(\Throwable $e) {
            report($e);

            return $this->sendResponse('failed', 'Failed to change password', $e->getMessage(), 500);
        }
    }
}