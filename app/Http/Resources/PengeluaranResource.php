<?php

namespace App\Http\Resources;

use Carbon\Carbon;
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
            'tanggal' => Carbon::parse($this->tanggal)->format('d M Y'),
            'business_id' => $this->business_id,
            'total_pengeluaran' => $this->total_pengeluaran,
            'detail_pengeluaran' => $this->detail_pengeluaran
        ];
    }
}
