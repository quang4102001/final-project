<?php

namespace App\Models;

use Illuminate\Contracts\Auth\CanResetPassword;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Ramsey\Uuid\Uuid;

class User extends Authenticatable implements CanResetPassword
{
    use HasFactory;
    use SoftDeletes;
    use Notifiable;

    protected $keyType = 'string';
    public $incrementing = false;
    protected $fillable = ['id', 'username', 'name', 'password', 'email', 'role', 'remember_token'];

    protected $hidden = [
        'password', 'remember_token'
    ];

    protected $guard = 'web';

    public function isUser()
    {
        return $this->role === 'user';
    }
}
