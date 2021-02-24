<?php

namespace App\Http\Controllers;

use GuzzleHttp\Client;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function sendResponse($status , $message, $data, $http_status) {
        return response()->json([
            'status' => $status,
            'message' => $message,
            'data' => $data,
        ], $http_status);
    }

    public function uploadImage($image) {
        $image_enc = base64_encode(file_get_contents($image));

        $client = new Client;
        $response = $client->request('POST', 'https://freeimage.host/api/1/upload', [
            'form_params' => [
                'key'       => '6d207e02198a847aa98d0a2a901485a5',
                'action'    => 'upload',
                'source'    => $image_enc,
                'format'    => 'json'
            ]
        ]);

        $image_url = json_decode($response->getBody())->image->display_url;

        return $image_url;
    }

    public function checkAuthRole($check) {
        return Auth::user()->role == $check ? true : false; 
    }

    // public function optionalResponse()
    // {

    // }
}
