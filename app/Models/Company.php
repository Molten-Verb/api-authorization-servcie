<?php

namespace App\Models;

use App\Models\Role;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Company extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
    ];

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'users_companies');
    }

    public function roles(): BelongsToMany
    {
        return $this->belongsToMany(Role::class, 'user_company_roles');
    }
}
