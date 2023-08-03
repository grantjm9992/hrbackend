<?php

namespace App\Models\AcademyContext;

use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    use HasFactory;
    use Uuids;

    protected $fillable = [
        'company_id',
        'name',
        'description',
        'price',
        'currency',
        'billing_cycle',
        'status',
        'course_category_id',
    ];
}
