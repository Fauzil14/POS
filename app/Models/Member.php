<?php

namespace App\Models;

use App\Helpers\CodeGenerator;
use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
    use CodeGenerator;
    
    protected $fillable = [
                            'kode_member'
                            ,'nama'
                            ,'no_telephone'
                            ,'saldo'
                          ];

    protected static function boot() {
        parent::boot();

        static::creating(function($query) {
            $query->kode_member = parent::setKodeMember();
        });
    }
    
    public function setKodeMember() {
        return $this->kodeMember();
    }

    public function penjualan() {
        return $this->hasMany('App\Models\Penjualan', 'member_id', 'id');
    }
    
}
