<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    protected $token;

    public function __construct($resource, $token = null)
    {
        parent::__construct($resource);
        $this->token = $token;
    }

    public function toArray($request)
    {
        return [
            'status' => 200,
            'token' => $this->token,
            'company' => [
                'name' => $this->companies->pluck('name'),
                'roles' => $this->roles->pluck('name'),
            ],
        ];
    }
}
