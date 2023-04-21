<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FoodOrders extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_number',
        'date',
        'total_amount',
    ];


    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->order_number = self::generateOrderNumber();
            $model->total_amount = 0;
        });
    }

    public static function generateOrderNumber()
    {
        // $letters = str_shuffle('ABCDEFGHIJKLMNOPQRSTUVWXYZ');
        // $letters = substr($letters, 0, 4);
        // $digits = strval(rand(100000, 999999));
        // return $letters . $digits;

        $digits = strval(rand(100000, 999999));
        return  $digits;
    }

    public function items()
    {
        return $this->hasMany(FoodOrderItem::class);
    }
}
