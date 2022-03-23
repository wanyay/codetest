<?php

use App\Http\Controllers\CouponController;
use App\Http\Controllers\CouponShopController;
use App\Http\Controllers\ShopController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('coupons', [CouponController::class, 'getCoupons']);
Route::get('coupons/{id}', [CouponController::class, 'getCoupon']);
Route::put('coupons/{id}', [CouponController::class, 'updateCoupon']);
Route::post('coupons', [CouponController::class, 'createCoupon']);
Route::delete('coupons/{id}', [CouponController::class, 'deleteCoupon']);


Route::post('/coupons/{coupon_id}/shops', [CouponShopController::class, 'couponShop']);
Route::get('/coupons/{coupon_id}/shops', [CouponShopController::class, 'getCouponShops']);
Route::get('/coupons/{coupon_id}/shops/{shop_id}', [CouponShopController::class, 'getCouponShopByShopId']);
Route::delete('/coupons/{coupon_id}/shops/{shop_id}', [CouponShopController::class, 'deleteCouponShop']);

Route::get('shops', [ShopController::class, 'getShops']);
Route::get('shops/{id}', [ShopController::class, 'getShop']);
Route::put('shops/{id}', [ShopController::class, 'updateShop']);
Route::post('shops', [ShopController::class, 'createShop']);
Route::delete('shops/{id}', [ShopController::class, 'deleteShop']);


