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
            
            $pengeluaran->business->business_transaction()->create([
                'transaction_id'    => $model->id,
                'jenis_transaksi'   => 'pengeluaran',
                'pengeluaran'       => $model->subtotal_pengeluaran,
                'saldo_transaksi'   => $pengeluaran->business->keuangan->saldo - $model->subtotal_pengeluaran,
                'created_at'        => $model->created_at,
            ]);
            $pengeluaran->business->keuangan->increment('pengeluaran', $model->subtotal_pengeluaran);
            $pengeluaran->business->keuangan->decrement('saldo', $model->subtotal_pengeluaran);
        });

        static::updated(function($model) {
            $pengeluaran = Pengeluaran::find($model->pengeluaran_id);
            $pengeluaran->update([ 'total_pengeluaran' => $pengeluaran->detail_pengeluaran()->sum('subtotal_pengeluaran') ]);
        });
    }

    public function pengeluaran() {
        return $this->hasOne('App\Models\Pengeluaran', 'id', 'pengeluaran_id');
    }

    public function pegawai() {
        return $this->hasOne(User::class, 'id', 'pegawai_id');
    }

    public function beban() {
        return $this->hasOne(Beban::class, 'id', 'beban_id');
    }

}
