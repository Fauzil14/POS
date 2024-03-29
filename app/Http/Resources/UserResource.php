<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $result = [
            'name'              => $this->name,
            'email'             => $this->email,
            'email_verified_at' => $this->email_verified_at,
            'umur'              => $this->umur,
            'alamat'            => $this->alamat,
            'profile_picture'   => $this->profile_picture,
            'role'              => $this->roles()->first()->role_name ?? "Anda belum memiliki role",
            'business_id'       => $this->roles->pluck('pivot.business_id')->first() ?? "Anda belum memiliki bisnis",
        ];

        if(isset($this->roles()->first()->role_name)) {
            if($this->roles()->first()->role_name == 'kasir') {
                $result = array_merge($result, [
                    'is_on_shift'   => $this->kasir->first()->status
                ]);
            }
        }
        
        return $result;
    }
}
