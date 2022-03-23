<?php

namespace App\Http\Controllers;

use App\Http\Resources\CouponResource;
use App\Services\CouponService;
use App\Services\ShopService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use function Psy\sh;

class CouponController extends Controller
{

    protected $couponService;

    protected $shopService;

    public function __construct(CouponService $couponService , ShopService $shopService)
    {
        $this->couponService = $couponService;
        $this->shopService = $shopService;
    }

    public function getCoupons(Request $request)
    {
        $name = $request->has('name') ? $request->name : null;
        $limit = $request->has('limit') ? $request->limit : 30;
        $offset = $request->has('offset') ? $request->offset : 0;

        $data = $this->couponService->getList($name, $limit, $offset);

        return successResponseWithLimit($request, 200, CouponResource::collection($data));
    }

    public function getCoupon($id, Request $request)
    {
        $data = $this->couponService->findById($id);

        if (!$data) {
            return errorResponse($request,
                404,
                "The resource that matches the request ID does not found.",
                404002
            );
        }

        return successResponse($request, 200, new CouponResource($data));
    }

    public function createCoupon(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:128',
            'discount_type' => 'required|in:percentage,fix-amount',
            'amount' => 'required|integer',
            'image_url' => 'required|string',
            'code' => 'integer',
            'start_datetime' => 'date_format:Y-m-d H:i:s',
            'end_datetime' => 'date_format:Y-m-d H:i:s|after:start_datetime',
            'coupon_type' => 'required|in:public,private',
            'used_count' => 'integer|max:10'
        ]);

        if ($validator->fails()) {
            $validation = getValidationErrorMessages($validator);
            return validationResponse($request, 400, $validation, 400002);
        }
        $coupon = $this->couponService->save($request->all());
        $data['id'] = $coupon->id;
        return successResponse($request, 200, $data);

    }

    public function updateCoupon($id, Request $request)
    {
        $data = $this->couponService->findById($id);

        if (!$data) {
            return errorResponse(
                $request,
                404,
                "The updating resource that corresponds to the ID wasn't found.",
                404002
            );
        }

        $validator = Validator::make($request->all(), [
            'name' => 'max:128|required|string',
            'discount_type' => 'required|in:percentage,fix-amount',
            'amount' => 'required|integer',
            'image_url' => 'required|string',
            'code' => 'integer',
            'start_datetime' => 'date_format:Y-m-d H:i:s',
            'end_datetime' => 'date_format:Y-m-d H:i:s|after:start_datetime',
            'coupon_type' => 'required|in:public,private',
            'used_count' => 'integer|max:10'
        ]);

        if ($validator->fails()) {
            $validation = getValidationErrorMessages($validator);
            return validationResponse($request, 400, $validation, 400002);
        }

        $coupon = $this->couponService->update($id, $request->all());
        return successResponse($request, 201, [ 'id' => $coupon->id]);
    }

    public function deleteCoupon($id, Request $request)
    {
        $data = $this->couponService->findById($id);

        if (!$data) {
            return errorResponse(
                $request,
                404,
                "The deleting resource that corresponds to the ID wasn't found.",
                404002
            );
        }
        $this->couponService->delete($id, $request->all());
        return successResponse($request, 200, [ 'deleted' => 1]);
    }
}
