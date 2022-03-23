<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CouponResource extends JsonResource
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
            'description' => $this->description,
            'discount_type' => $this->discount_type,
            'amount' => $this->amount,
            'image_url' => $this->image_url,
            'code' => $this->code,
            'start_datetime' => $this->start_datetime,
            'end_datetime' => $this->end_datetime,
            'coupon_type' => $this->coupon_type,
            'used_count' => $this->used_count,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at
        ];
    }
}
