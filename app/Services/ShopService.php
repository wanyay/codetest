<?php
namespace App\Services;

use App\Models\Shop;

class ShopService
{

    protected $model;

    public function __construct(Shop $shop)
    {
        $this->model = $shop;
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
        $shop = $this->findById($id);
        $shop->update($data);
        return $shop;
    }

    public function delete($id)
    {
        $shop = $this->findById($id);
        $shop->delete();
    }


}
