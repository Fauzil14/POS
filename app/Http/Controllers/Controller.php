<?php

namespace App\Http\Controllers;

use GuzzleHttp\Client;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

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

    // public function optionalResponse()
    // {

    // }
}
