<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderPaymentMethod extends Model
{
    protected $table = 'order_payment_method';

    public function order(){
        return $this->belongsTo(Order::class, 'order_id');
    }

    public $guarded = [];
}
