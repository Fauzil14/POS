<?php

namespace App\Http\Resources;

use Illuminate\Support\Str;
use Illuminate\Http\Resources\Json\JsonResource;

class LaporanPenjualanByDayResource extends JsonResource
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
            "nama_kasir" => is_null($this->user) ? "Kasir tidak ada atau sudah dihapus" : $this->user->name,
            "kode_kasir" => is_null($this->kasir) ? "Kasir tidak ada atau sudah dihapus" : $this->kasir->kode_user,
            "total_price" => Str::decimalForm($this->total_price, true),
            "tanggal" => $this->created_at->translatedFormat('l d-m-Y'),
            "waktu_transaksi" => $this->created_at->translatedFormat('H:i'),
        ];
    }
}
