<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Ramsey\Uuid\Uuid;
use Illuminate\Contracts\Auth\CanResetPassword;

class Admin extends Authenticatable implements CanResetPassword
{
    use HasFactory, SoftDeletes, Notifiable;

    protected $keyType = 'string';
    public $incrementing = false;
    protected $fillable = ['id', 'username', 'name', 'password', 'email', 'role', 'remember_token'];

    protected $hidden = [
        'password', 'remember_token'
    ];

    protected $guard = 'admin';

    public function isAdmin()
    {
        return $this->role === 'admin';
    }
}
