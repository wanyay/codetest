<?php

namespace App\Http\Controllers;

use App\Http\Resources\CouponShopResource;
use App\Models\CouponShop;
use App\Services\CouponService;
use App\Services\ShopService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CouponShopController extends Controller
{
    protected $couponService;

    protected $shopService;

    public function __construct(CouponService $couponService , ShopService $shopService)
    {
        $this->couponService = $couponService;
        $this->shopService = $shopService;
    }

    public function couponShop(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'coupon_id' => 'required|integer',
            'shop_id' => 'required|integer',
        ]);

        if ($validator->fails()) {
            $validation = getValidationErrorMessages($validator);
            return validationResponse($request, 400, $validation, 400002);
        }

        $coupon = $this->couponService->findById($request->coupon_id);
        $shop = $this->shopService->findById($request->shop_id);

        if (!$coupon || !$shop) {
            return errorResponse(
                $request,
                404,
                "The parent resource of corresponding to the given ID was not found.",
                404002
            );
        }

        if ($shop->coupons->contains($coupon->id)) {
            return errorResponse(
                $request,
                409,
                "The inserting resource was already registered.",
                409001
            );
        }

        $couponShop = CouponShop::create([
            'coupon_id' => $coupon->id,
            'shop_id' => $shop->id,
            'update'
        ]);

        return successResponse($request, 201, ["id" => $couponShop->id]);
    }

    public function getCouponShops($coupon_id, Request $request)
    {
        $limit = $request->has('limit') ? $request->limit : 30;
        $offset = $request->has('offset') ? $request->offset : 0;

        $data = $this->couponService->getCouponShops($coupon_id, $limit, $offset);

        return successResponse($request, 200, CouponShopResource::collection($data));

    }

    public function getCouponShopByShopId($coupon_id, $shop_id, Request $request)
    {
        $shop = $this->shopService->findById($shop_id);
        $data = $this->couponService->getCouponShopsByShopId($coupon_id, $shop_id);
        $data['shop'] = $shop;
        return successResponse($request, 200, $data);
    }

    public function deleteCouponShop($coupon_id, $id, Request $request)
    {
        $couponShop = CouponShop::where('id', $id)->first();

        if (!$couponShop) {
            return errorResponse(
                $request,
                404,
                "The parent resource of corresponding to the given ID was not found.",
                404002
            );
        }

        $couponShop->delete();

        return successResponse($request, 200, [ 'deleted' => 1]);

    }
}
