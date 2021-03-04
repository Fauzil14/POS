<?php

namespace App\Http\Controllers;

use App\Models\Shift;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\ShiftResource;
use Illuminate\Validation\ValidationException;

class ShiftController extends Controller
{
    public function startShift()
    {
        if( Auth::user()->kasir->first()->status == 'on_shift' ) {
            throw ValidationException::withMessages(['message' => 'Anda saat ini dalam shift']);
        }

        $shift = Shift::create([
            'kasir_id'    => Auth::user()->kasir->first()->id,
            'start_time'  => now()
        ]);

        $data = new ShiftResource($shift);

        return $this->sendResponse('success', 'Anda sudah memulai shift kerja anda', $data, 200);
    }

    public function endShift()
    {
        if( Auth::user()->kasir->first()->status == 'not_on_shift' ) {
            throw ValidationException::withMessages(['message' => 'Shfit anda belum berjalan']);
        }

        $shift = Shift::where(function($q) {
            $q->where('kasir_id', Auth::user()->kasir->first()->id)
                ->where('end_time', null);
        })->first();
        $shift->end_time = now();
        $shift->update();

        $data = new ShiftResource($shift);

        return $this->sendResponse('success', 'Anda sudah memulai shift kerja anda', $data, 200);
    }
}
