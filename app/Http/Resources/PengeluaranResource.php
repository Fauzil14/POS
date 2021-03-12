<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PengeluaranResource extends JsonResource
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
            'tanggal' => $this->tanggal,
            'business_id' => $this->business_id,
            'total_pengeluaran' => $this->total_pengeluaran,
            'detail_pengeluaran' => $this->detail_pengeluaran
        ];
    }
}
