<?php

namespace S25\Auth\UserProvider;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id'                => $this->id,
            'positionName'      => $this->positionName,
            'firstName'         => $this->firstName,
            'lastName'          => $this->lastName,
            'phone'             => $this->phone,
            'personnelNumber'   => $this->personnelNumber,
            "timezoneId"        => $this->timezoneId,
            "createdAt"         => $this->createdAt,
            "photo"             => $this->photo,
            "avatar"            => $this->avatar,
            "avatar2x"          => $this->avatar2x,
        ];
    }
}

