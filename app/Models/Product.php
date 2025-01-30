<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $table = 'products';

    protected $primaryKey = 'pro_id';

    public function product_images() {
        return $this->hasMany(ProductImage::class ,'pro_id', 'pro_id');
    }

}
