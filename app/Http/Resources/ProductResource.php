<?php

namespace App\Http\Resources;

use Illuminate\Support\Str;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
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
            'uid'           => $this->uid, 
            'merek'         => $this->merek,
            'nama'          => $this->nama,
            'category_name' => ucfirst($this->category->category_name),
            'nama_supplier' => $this->supplier->nama_supplier,
            'stok'          => $this->stok,
            'harga_beli'    => Str::decimalForm($this->harga_beli, true),
            'harga_jual'    => Str::decimalForm($this->harga_jual, true),
            'diskon'        => is_null($this->diskon) ? '-' : $this->diskon,
        ];
    }
}
