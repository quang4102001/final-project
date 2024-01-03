<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Webpatser\Uuid\Uuid;

class Product extends Model
{
    use HasFactory, SoftDeletes;

    protected $primaryKey = 'id';
    public $incrementing = false;
    protected $keyType = 'uuid';

    protected $fillable = [
        'name',
        'sku',
        'price',
        'discounted_price',
        'category',
        'status'
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->id = Uuid::generate()->string;
        });
    }

    public function colors()
    {
        return $this->belongsToMany(Color::class, 'product_color');
    }
    public function sizes()
    {
        return $this->belongsToMany(Size::class, 'product_size');
    }
    public function images()
    {
        return $this->belongsToMany(Image::class, 'product_image');
    }

    public function carts() {
        return $this->belongsToMany(Cart::class, 'cart_detail')->withPivot('qty', 'color');
    }

    public function cartDetail()
    {
        return $this->hasMany(CartDetail::class, 'product_id');
    }
}
