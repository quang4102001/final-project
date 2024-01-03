<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Webpatser\Uuid\Uuid;

class CartDetail extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'cart_detail';

    protected $fillable = [
        'cart_id',
        'product_id',
        'color_id',
        'qty',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }

    public function colors(){
        return $this->belongsTo(Color::class, 'color_id', 'id');
    }
}

