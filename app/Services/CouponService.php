<?php
namespace App\Services;

use App\Models\Coupon;

class CouponService
{

    protected $model;

    public function __construct(Coupon $coupon)
    {
        $this->model = $coupon;
    }

    public function getList($name, $limit = 30, $offset = 0)
    {
        $query = $this->model->query();

        if ($name !== null ) {
            $query = $query->where('name', 'like', '%' . $name . '%');
        }

        return $query->skip($offset)->take($limit)->get();
    }

    public function findById($id)
    {
        return $this->model->where('id', $id)->first();
    }

    public function save($data)
    {
        $data['admin_id'] = 1;
        return $this->model->create($data);
    }

    public function update($id, $data)
    {
        $coupon = $this->findById($id);
        $coupon->update($data);
        return $coupon;
    }

    public function delete($id)
    {
        $coupon = $this->findById($id);
        $coupon->delete();
    }

    public function getCouponShops($coupon_id, $limit, $offset)
    {
        return $this->model->with('shops')->where('id', $coupon_id)->skip($offset)->take($limit)->get();
    }


    public function getCouponShopsByShopId($coupon_id, $shop_id)
    {
        return $this->model->where('id', $coupon_id)
            ->whereHas('shops', function ($subQuery) use ($shop_id) {
                return $subQuery->where('shops.id', $shop_id);
            })->first();
    }
}
