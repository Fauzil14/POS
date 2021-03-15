<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class DetailPembelianResource extends JsonResource
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
            "pembelian_id" => $this->pembelian_id,
            "product_id" => $this->product_id,
            "nama_product" => is_null($this->product) ? "Produk tidak ada atau sudah dihapus" : $this->product->nama,
            "quantity" => $this->quantity,
            "harga_beli" => $this->harga_beli,
            "harga_jual" => $this->harga_jual,
            "subtotal_harga" => $this->subtotal_harga,
            "created_at" => $this->created_at,
            "updated_at" => $this->updated_at
        ];
    }
}
