<?php

namespace App\Http\Resources;

use Illuminate\Support\Str;
use Illuminate\Http\Resources\Json\JsonResource;

class LaporanPembelianByDayResource extends JsonResource
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
            "nama_staff" => is_null($this->user) ? "Staff tidak ada atau sudah dihapus" : $this->user->name,
            "kode_staff" => is_null($this->staff) ? "Staff tidak ada atau sudah dihapus" : $this->staff->kode_user,
            "nama_supplier" => is_null($this->supplier) ? "Supplier tidak ada atau sudah di hapus" : $this->supplier->nama_supplier,
            "total_price" => Str::decimalForm($this->total_price, true),
            "tanggal" => $this->created_at->translatedFormat('l d-m-Y'),
            "waktu_transaksi" => $this->created_at->translatedFormat('H:i'),
        ];
    }
}
