<?php

namespace App\Http\Resources;

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
            'kode_kasir'               => $this->kasir->kode_user,
            'start_time'               => $this->start_time,
            'end_time'                 => $this->end_time,
            'transaction_on_shift'     => $this->transaction_on_shift,
            'total_penjualan_on_shift' => $this->total_penjualan_on_shift,
        ];
    }
}
