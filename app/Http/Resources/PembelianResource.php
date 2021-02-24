<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PembelianResource extends JsonResource
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
            "staff_id" => $this->staff_id,
            "supplier_id" => $this->supplier_id,
            "total_price" => $this->total_price,
            "status" => $this->status,
            "created_at" => $this->created_at,
            "updated_at" => $this->updated_at,
            "detail_pembelian" => $this->detail_pembelian,
        ];
    }
}
