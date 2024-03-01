<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Config;
use Webpatser\Uuid\Uuid;

class Image extends Model
{
    use HasFactory,SoftDeletes;

    protected $primaryKey = 'id';
    public $incrementing = false;
    protected $keyType = 'uuid';

    protected $fillable = ['id', 'path'];

    public function products() {
        return $this->belongsToMany(Product::class,'product_image');
    }

    // public function path ():Attribute {
    //     return Attribute::make(
    //         get: fn(string $value) => Config::get('app.url') . $value,
    //     );
    // }
}
