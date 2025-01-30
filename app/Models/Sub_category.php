<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sub_category extends Model
{
    use HasFactory;

    protected $table = 'sub_categories';

    protected $primaryKey = 'sub_id';

    // public function category() 
    // {
    //     return $this->belongsTo(Category::class); 
    // }

}
