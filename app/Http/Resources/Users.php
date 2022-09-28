<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Users extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return parent::toArray($request);

        // This return custom database columns value
        // Here you can customize your data to show
        // return [
        //     'id' => $this->id,
        //     'subjectName' => $this->subjectName." Sub"
        // ];
    }
}
