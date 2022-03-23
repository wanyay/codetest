<?php

namespace App\Http\Controllers;

use App\Services\ShopService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ShopController extends Controller
{

    protected $shopService;

    public function __construct(ShopService $shopService)
    {
        $this->shopService = $shopService;
    }

    public function getshops(Request $request)
    {
        $name = $request->has('name') ? $request->name : null;
        $limit = $request->has('limit') ? $request->limit : 30;
        $offset = $request->has('offset') ? $request->offset : 0;

        $data = $this->shopService->getList($name, $limit, $offset);

        return successResponseWithLimit($request, 200, $data);
    }

    public function getshop($id, Request $request)
    {
        $data = $this->shopService->findById($id);

        if (!$data) {
            return errorResponse($request,
                404,
                "The resource that matches the request ID does not found.",
                404002
            );
        }

        return successResponse($request, 200, $data);
    }

    public function createshop(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:128',
            'query' => 'string',
            'latitude' => 'numeric',
            'longitude' => 'numeric',
            'zoom' => 'integer'
        ]);

        if ($validator->fails()) {
            $validation = getValidationErrorMessages($validator);
            return validationResponse($request, 400, $validation, 400002);
        }
        $shop = $this->shopService->save($request->all());
        $data['id'] = $shop->id;
        return successResponse($request, 201, $data);

    }

    public function updateshop($id, Request $request)
    {
        $data = $this->shopService->findById($id);

        if (!$data) {
            return errorResponse(
                $request,
                404,
                "The updating resource that corresponds to the ID wasn't found.",
                404002
            );
        }

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:128',
            'query' => 'string',
            'latitude' => 'numeric',
            'longitude' => 'numeric',
            'zoom' => 'integer'
        ]);

        if ($validator->fails()) {
            $validation = getValidationErrorMessages($validator);
            return validationResponse($request, 400, $validation, 400002);
        }

        $shop = $this->shopService->update($id, $request->all());
        return successResponse($request, 200, [ 'id' => $shop->id]);
    }

    public function deleteshop($id, Request $request)
    {
        $data = $this->shopService->findById($id);

        if (!$data) {
            return errorResponse(
                $request,
                404,
                "The deleting resource that corresponds to the ID wasn't found.",
                404002
            );
        }
        $this->shopService->delete($id, $request->all());
        return successResponse($request, 200, [ 'deleted' => 1]);
    }
}
