<?php

namespace App\Providers;

use App\Models\User;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\ServiceProvider;
use Illuminate\Auth\Notifications\VerifyEmail;
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
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // change email notification message
        VerifyEmail::toMailUsing(function (User $user, string $verificationUrl) {
            return (new MailMessage)
                ->subject(Lang::get('Verifikasi Email Anda'))
                ->line(Lang::get('Silahkan klik tombol dibawah ini untuk verifikasi email anda.'))
                ->action(Lang::get('Verifikasi Email'), $verificationUrl)
                ->line(Lang::get('Abaikan pesan jika anda sudah verifikasi atau belum memiliki akun.'));
        });
    }
}
