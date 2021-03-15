<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class LaporanPembelianResource extends JsonResource
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
            "kode_transaksi" => $this->kode_transaksi,
            "nama_staff" => $this->user->name,
            "kode_staff" => $this->staff->kode_user,
            "total_price" => $this->total_price,
            "status" => $this->status,
            "created_at" => $this->created_at->translatedFormat('H:i'),
            "detail_penjualan" => DetailPembelianResource::collection($this->detail_penjualan)
        ];
    }
}
