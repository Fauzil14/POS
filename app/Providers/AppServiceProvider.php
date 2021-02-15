<?php

namespace App\Providers;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Validator;
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

        Validator::extend('check_password', function($attribute, $value, $parameters, $validator) {
            $email = ($validator->getData())['email'];
            $custom_message = "Password yang anda masukkan salah";
            
            // if( User::where('email', $email)->exists() ) {
            //     return true;
            // }
            if ( Auth::attempt(['email' => $email, 'password' => $value]) ) {
                return true;
            } else {
                return false;
            }

            // $validator->addReplacer('check_password', function($message, $attribute, $rule, $parameters) use ($custom_message) {
            //     return str_replace(':custom_message', $custom_message, $message);
            // });
            $validator->addReplacer('check_password', function($message, $attribute, $rule, $paramaters) use ($custom_message) {
                return str_replace(':custom_message', $custom_message, $message);
            });

        }, ":custom_message");
    }
}
