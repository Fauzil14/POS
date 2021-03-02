<?php

namespace App\Http\Controllers;

use App\Models\Shift;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\ShiftResource;

class ShiftController extends Controller
{
    public function startShift()
    {

        $shift = Shift::create([
            'kasir_id'    => Auth::user()->kasir->first()->id,
            'start_time'  => now()
        ]);

        $data = new ShiftResource($shift);

        return $this->sendResponse('success', 'Shfit anda sudah mulai', $data, 200);
    }
}
