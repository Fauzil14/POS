<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class DetailPenjualanResource extends JsonResource
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
            "penjualan_id" => $this->penjualan_id,
            "product_id" => $this->product_id,
            "nama_product" => $this->product->nama,
            "quantity" => $this->quantity,
            "harga_jual" => $this->harga_jual,
            "diskon" => $this->diskon,
            "subtotal_harga" => $this->subtotal_harga,
            "created_at" => $this->created_at,
            "updated_at" => $this->updated_at
        ];
    }
}
