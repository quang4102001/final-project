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

    protected $guarded = [];

    protected $guard = 'web';

    public function __construct(array $attributes = [])
    {
        // Thêm điều kiện để sinh UUID nếu chưa có
        if (!isset($attributes['id'])) {
            $attributes['id'] = Uuid::uuid4()->toString();
        }

        parent::__construct($attributes);
    }

    public function isAdmin()
    {
        return $this->hasRole('admin');
    }
}
