<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FoodOrderItem extends Model
{
    use HasFactory;

    protected $fillable = ['food_order_id', 'food_item_id', 'price'];

    public function order()
    {
        return $this->belongsTo(FoodOrders::class, 'food_order_id');
    }

    public function item()
    {
        return $this->belongsTo(Food::class, 'food_item_id');
    }
}
