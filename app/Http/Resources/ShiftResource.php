<?php

namespace App\Http\Resources;

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Resources\Json\JsonResource;

class ShiftResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {

        return [
            'kasir_id'                 => $this->kasir_id,
            'kode_kasir'               => $this->kasir->kode_user,
            'start_time'               => $this->start_time,
            'end_time'                 => is_null($this->end_time) ? $this->end_time : $this->end_time->toDateTimeString(),
            'transaction_on_shift'     => $this->transaction_on_shift,
            'total_penjualan_on_shift' => $this->total_penjualan_on_shift,
            'duration'                 => $this->when(is_null($this->end_time) == false, $this->end_time->timespan($this->start_time))
        ];
    }
}
