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
            "diskon_member" => is_null($this->business) ? null : $this->business->diskon_member,
            "nama_kasir" => is_null($this->user) ? "Kasir tidak ada atau sudah di hapus" : $this->user->name,
            "kode_kasir" => is_null($this->kasir) ? "Kasir tidak ada atau sudah di hapus" : $this->kasir->kode_user,
            "kode_member" => is_null($this->member) ? "Member tidak ada atau sudah di hapus" : $this->member->kode_member,
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
