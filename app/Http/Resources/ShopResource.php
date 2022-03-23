<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ShopResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'admin_id' => $this->admin_id,
            'query' => $this->query,
            'latitude' => $this->latitude,
            'longitude' => $this->longtitude,
            'zoom' => $this->zoom,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at
        ];
    }
}
