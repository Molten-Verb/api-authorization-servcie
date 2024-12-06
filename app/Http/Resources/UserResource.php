<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'status' => 200,
            'companies' => $this->companies->map(function ($company) {
                $roles = $company->roles->pluck('name');
                return [
                    'name' => $company->name,
                    'roles' => $roles,
                ];
            }),
        ];
    }
}
