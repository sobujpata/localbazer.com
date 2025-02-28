<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable; // Important for guards
use Illuminate\Notifications\Notifiable;

class Admin extends Authenticatable
{
    use Notifiable;

    protected $fillable = ['fname', 'email', 'mobile', 'password', 'otp', 'role'];

    protected $hidden = ['password', 'remember_token']; // Hide sensitive data

    /**
     * Automatically hash the password when setting it.
     *
     * @param string $value
     */
    
}
