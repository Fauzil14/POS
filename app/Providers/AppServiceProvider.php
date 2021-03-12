<?php

namespace App\Providers;

use App\Models\User;
use App\Models\Pembelian;
use App\Models\Penjualan;
use Illuminate\Support\Str;
use Illuminate\Support\Carbon;
use App\Observers\PembelianObserver;
use App\Observers\PenjualanObserver;
use App\Validation\BailingValidator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Validator;
use Illuminate\Contracts\Validation\Factory;
use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Contracts\Translation\Translator;
use Illuminate\Notifications\Messages\MailMessage;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        config(['app.locale' => 'id']);
        Carbon::setLocale('id');
        date_default_timezone_set('Asia/Jakarta');
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Pembelian::observe(PembelianObserver::class);
        Penjualan::observe(PenjualanObserver::class);

        // change email notification message
        VerifyEmail::toMailUsing(function (User $user, string $verificationUrl) {
            return (new MailMessage)
                ->subject(Lang::get('Verifikasi Email Anda'))
                ->line(Lang::get('Silahkan klik tombol dibawah ini untuk verifikasi email anda.'))
                ->action(Lang::get('Verifikasi Email'), $verificationUrl)
                ->line(Lang::get('Abaikan pesan jika anda sudah verifikasi atau belum memiliki akun.'));
        });

        Str::macro('decimalForm', function($value, $is_currency = false) {            
            if( $is_currency == true ) {
                return number_format($value, 2, ',', '.');
            }
            
            if( is_numeric($value) && floor($value) != $value ) {
                $decimals = (strlen($value) - strpos($value, '.')) - 1;
                return number_format($value, $decimals, ',', '.');
            } else {
                return number_format($value, 0, ',', '.');
            }
        });

    }
}
