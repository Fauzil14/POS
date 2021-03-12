<?php

namespace App\Models;

use App\Models\Pengeluaran;
use Illuminate\Database\Eloquent\Model;

class DetailPengeluaran extends Model
{
    protected $fillable = [
        'pengeluaran_id'
        ,'pegawai_id'
        ,'beban_id'
        ,'deskripsi'
        ,'subtotal_pengeluaran'
    ];


    protected static function boot()
    {
        parent::boot();

        static::created(function($model) {
            $pengeluaran = Pengeluaran::find($model->pengeluaran_id);
            $pengeluaran->update([ 'total_pengeluaran' => $pengeluaran->detail_pengeluaran()->sum('subtotal_pengeluaran') ]);
        });

        static::updated(function($model) {
            $pengeluaran = Pengeluaran::find($model->pengeluaran_id);
            $pengeluaran->update([ 'total_pengeluaran' => $pengeluaran->detail_pengeluaran()->sum('subtotal_pengeluaran') ]);
        });
    }

    public function pengeluaran() {
        return $this->hasOne('App\Models\Pengeluaran', 'id', 'pengeluaran_id');
    }
}
