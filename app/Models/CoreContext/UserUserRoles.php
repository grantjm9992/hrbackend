<?php

namespace App\Models\CoreContext;

use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserUserRoles extends Model
{
    use HasFactory;
    use Uuids;

    protected $fillable = [
        'user_id', 'user_role', 'company_id',
    ];
}
