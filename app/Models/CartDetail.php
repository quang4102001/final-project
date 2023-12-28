<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Webpatser\Uuid\Uuid;

class UserCart extends Model
{
    use HasFactory,SoftDeletes;

    protected $fillable = [
        'cart_id',
        'product_id',
        'qty',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->id = Uuid::generate()->string;
        });
    }
}
