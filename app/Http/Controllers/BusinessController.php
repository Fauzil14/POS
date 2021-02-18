<?php

namespace App\Http\Controllers;

use App\Models\Business;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BusinessController extends Controller
{
    public function updateBusiness(Request $request) 
    {
        $bisnis = Business::firstWhere('admin_id', Auth::id());

        $validatedData = $request->validate([
            'nama_bisnis'   => 'sometimes',
            'alamat_bisnis' => 'sometimes',
            'telepon'       => 'sometimes',
            'logo_bisnis'   => 'image|mimes:jpg,png,jpeg|max:2048',
            'diskon_member' => 'sometimes',
        ]);
            
        try {
            collect($validatedData)->each(function($item, $key) use ($bisnis) {
                $bisnis->{$key} = $item; 
                if($key == 'logo_bisnis') {
                    $bisnis->logo_bisnis =  $this->uploadImage($item);
                } 
            });
            $bisnis->update();
    
            if( $request->wantsJson() ) {
                return $this->sendResponse('success', 'Data bisnis has been successfully updated', $bisnis, 200);
            } else {
                dd('return to view');
            }
        } catch(\Throwable $e) {
            if( $request->wantsJson() ) {
                return $this->sendResponse('failed', 'Data bisnis failed to update', $e->getMessage(), 500);
            } else {
                dd('return to view');
            }
        }
        

    }
}
