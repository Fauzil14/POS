<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;
use Illuminate\Validation\Rule;

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
            'email'           => [ 
                                   'sometimes',
                                   'email:rfc,dns', 
                                   Rule::unique('users')->ignore($authUser->id),
                                 ],
            // 'no_telephone'    => [
            //                         Rule::unique('users')->ignore($authUser->id),
            //                      ],
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
            return $this->sendResponse('failed', 'User data failed to update', null, 500);
        }
    }
}
