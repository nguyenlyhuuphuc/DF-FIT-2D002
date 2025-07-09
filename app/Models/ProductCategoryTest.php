<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductCategoryTest extends Model
{
    use HasFactory;

    protected $table = 'product_category_test';

    public $timestamps = true;

    // public $fillable = [];

    public $guarded = [];

    // public function products(){
    //     return $this->hasMany(Product::class, 'product_category_id');
    // }
}
