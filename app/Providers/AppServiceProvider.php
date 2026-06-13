<?php

namespace App\Providers;

use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;
use Symfony\Component\Mailer\Bridge\Brevo\Transport\BrevoTransportFactory;
use Symfony\Component\Mailer\Transport\Dsn;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Carbon::setLocale(config('app.locale'));

        // Forcer HTTPS + domaine public en production (Railway derrière un proxy).
        if ($this->app->environment('production')) {
            URL::forceScheme('https');
            URL::forceRootUrl(config('app.url'));
        }

        // Transport email Brevo via API HTTP (port 443) — nécessaire sur Railway
        // qui bloque les ports SMTP sortants (25/465/587).
        Mail::extend('brevo', function () {
            return (new BrevoTransportFactory())->create(
                new Dsn('brevo+api', 'default', config('services.brevo.key'))
            );
        });

        // Email de vérification d'adresse — en français
        VerifyEmail::toMailUsing(function ($notifiable, string $url) {
            return (new MailMessage)
                ->subject('Confirmez votre adresse email — ' . config('app.name'))
                ->greeting('Bonjour ' . ($notifiable->nom ?? '') . ',')
                ->line('Merci pour votre inscription ! Veuillez confirmer votre adresse email en cliquant sur le bouton ci-dessous.')
                ->action('Confirmer mon adresse email', $url)
                ->line("Si vous n'avez pas créé de compte, aucune action n'est requise.")
                ->salutation('À bientôt, ' . "\n" . config('app.name'));
        });

        // Email de réinitialisation du mot de passe — en français
        ResetPassword::toMailUsing(function ($notifiable, string $token) {
            $url = url(route('password.reset', [
                'token' => $token,
                'email' => $notifiable->getEmailForPasswordReset(),
            ], false));

            return (new MailMessage)
                ->subject('Réinitialisation de votre mot de passe — ' . config('app.name'))
                ->greeting('Bonjour,')
                ->line('Vous recevez cet email car nous avons reçu une demande de réinitialisation de mot de passe pour votre compte.')
                ->action('Réinitialiser le mot de passe', $url)
                ->line('Ce lien expirera dans ' . config('auth.passwords.users.expire', 60) . ' minutes.')
                ->line("Si vous n'avez pas demandé de réinitialisation, ignorez simplement cet email.")
                ->salutation('À bientôt, ' . "\n" . config('app.name'));
        });
    }
}
