<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $table = 'categories';

    protected $primaryKey = 'cat_id';

    public function sub_category() {
        return $this->hasMany(Sub_category::class, 'cat_id', 'cat_id', 'name');
    }

}
