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
            "nama_staff" => is_null($this->user) ? "Staff tidak ada atau sudah dihapus" : $this->user->name,
            "kode_staff" => is_null($this->staff) ? "Staff tidak ada atau sudah dihapus" : $this->staff->kode_user,
            "nama_supplier" => is_null($this->supplier) ? "Supplier tidak ada atau sudah di hapus" : $this->supplier->nama_supplier,
            "total_price" => $this->total_price,
            "status" => $this->status,
            "created_at" => $this->created_at->translatedFormat('H:i'),
            "detail_pembelian" => DetailPembelianResource::collection($this->detail_pembelian)
        ];
    }
}
