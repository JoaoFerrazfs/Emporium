<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Lang;

class ResetPasswordVerification extends Notification
{
    use Queueable;

    private mixed $token;
    private mixed $email;
    private mixed $name;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($token, $email, $name)
    {
        $this->token = $token;
        $this->email = $email;
        $this->name = $name;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        $url = url('reset-password').'/'. $this->token.'?email='.$this->email;
        $minutos = config('auth.passwords.'.config('auth.defaults.passwords').'.expire');

        return (new MailMessage)
            ->subject(Lang::get('Atualização de senha'))
            ->greeting('Olá ' . $this->name)
            ->line(Lang::get('Esqueceu a senha? Vamos resolver isso.'))
            ->action(Lang::get('Clique aqui para resetar a senha.'), $url)
            ->line(Lang::get('O link acima expira em ' .$minutos. ' minutos'))
            ->line(Lang::get('Se você não requisitou o reset de senha não é necessária nenhuma ação.'))
            ->salutation('Até breve.');
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
