<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CouponShop extends Model
{
    use HasFactory;

    protected $fillable = ['coupon_id', 'shop_id'];


}
