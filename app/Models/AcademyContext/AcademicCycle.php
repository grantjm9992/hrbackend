<?php

namespace App\Models\AcademyContext;

use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AcademicCycle extends Model
{
    use HasFactory;
    use Uuids;

    protected $fillable = [
        'company_id',
        'name',
        'tag_colour',
    ];
}
