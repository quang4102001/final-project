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
    protected $guarded = [];

    protected $guard = 'admin';

    public function __construct(array $attributes = [])
    {
        // Thêm điều kiện để sinh UUID nếu chưa có
        if (!isset($attributes['id'])) {
            $attributes['id'] = Uuid::uuid4()->toString();
        }

        parent::__construct($attributes);
    }
}
