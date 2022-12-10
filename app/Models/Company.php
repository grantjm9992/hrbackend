<?php declare(strict_types=1);

namespace App\Models;

use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    use \Backpack\CRUD\app\Models\Traits\CrudTrait;
    use HasFactory;
    use Uuids;

    protected $fillable = [
        'name',
        'admin_user_id',
        'address',
        'city',
        'country',
        'postcode',
        'number_of_employees',
        'sector_id',
    ];
}
