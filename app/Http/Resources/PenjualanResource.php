<?php

namespace App\Http\Resources;

use Illuminate\Support\Str;
use Illuminate\Http\Resources\Json\JsonResource;

class PenjualanResource extends JsonResource
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
            "id" => $this->id,
            "kode_transaksi" => $this->kode_transaksi,
            "business_id" => $this->business_id,
            "diskon_member" => $this->business->diskon_member,
            "kasir_id" => $this->kasir_id,
            "member_id" => $this->member_id,
            "total_price" => $this->total_price,
            "jenis_pembayaran" => $this->jenis_pembayaran,
            "dibayar" => $this->dibayar,
            "kembalian" => $this->kembalian,
            "status" => $this->status,
            "created_at" => $this->created_at,
            "updated_at" => $this->updated_at,
            "detail_penjualan" => DetailPenjualanResource::collection($this->detail_penjualan)
        ];
    }
}
