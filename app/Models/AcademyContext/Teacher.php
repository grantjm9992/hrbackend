<?php

namespace App\Models\AcademyContext;

use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Teacher extends Model
{
    use HasFactory;
    use Uuids;

    protected $fillable = [
        'company_id',
        'user_id',
        'text_colour',
        'colour',
        'hours',
        'hour_cycle',
    ];
}
