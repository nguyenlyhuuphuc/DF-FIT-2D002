<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductCategoryTest extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'product_category_test';

    public $timestamps = true;

    // public $fillable = [];

    public $guarded = [];

    // public function products(){
    //     return $this->hasMany(Product::class, 'product_category_id');
    // }
}
