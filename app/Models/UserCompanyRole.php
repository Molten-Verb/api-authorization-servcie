<?php

namespace App\Models;

use App\Models\Role;
use App\Models\User;
use App\Models\Company;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class UserCompanyRole extends Model
{
    use HasFactory;

    protected $fillable = [
        'company_id',
        'user_id',
        'role_id',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_company_roles');
    }

    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class, 'user_company_roles');
    }

    public function role(): BelongsTo
    {
        return $this->belongsTo(Role::class, 'user_company_roles');
    }
}
