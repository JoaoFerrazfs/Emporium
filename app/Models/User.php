<?php

namespace App\Models;

use App\Notifications\EmailVerification;
use App\Notifications\RedefinirSenhaNotification;
use App\Notifications\ResetPasswordVerification;
use App\Notifications\VerificarEmailNotification;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable implements  MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $dates = ['email_verified_at'];
    protected $fillable = [
        'name',
        'email',
        'password',
        'phone',
        'rule',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function sendPasswordResetNotification($token)
    {
        $this->notify(new ResetPasswordVerification($token, $this->email, $this->name));

    }

    public function sendEmailVerificationNotification()
    {
        $this->notify(new EmailVerification($this->name));
    }
}

