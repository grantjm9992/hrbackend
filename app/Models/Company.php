<?php declare(strict_types=1);

namespace App\Models;

use App\Traits\Uuids;
use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Company extends Model
{
    use CrudTrait;
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

    public function clients(): HasMany
    {
        return $this->hasMany(Clients::class);
    }
}
