<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    
    protected $table = 'product';

    public function productCategory(){
        return $this->belongsTo(ProductCategoryTest::class, 'product_category_id');
    }
}
