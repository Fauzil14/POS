<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class LaporanPenjualanResource extends JsonResource
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
            "diskon_member" => $this->business->diskon_member,
            "nama_kasir" => $this->user->name,
            "kode_kasir" => $this->kasir->kode_user,
            "kode_member" => $this->member->kode_member,
            "total_price" => $this->total_price,
            "jenis_pembayaran" => $this->jenis_pembayaran,
            "dibayar" => $this->dibayar,
            "kembalian" => $this->kembalian,
            "status" => $this->status,
            "created_at" => $this->created_at->translatedFormat('H:i'),
            "detail_penjualan" => DetailPenjualanResource::collection($this->detail_penjualan)
        ];
    }
}
