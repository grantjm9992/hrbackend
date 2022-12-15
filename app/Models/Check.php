<?php declare(strict_types=1);

namespace App\Models;

use App\Traits\Uuids;
use App\ValueObject\CheckStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Check extends Model
{
    use \Backpack\CRUD\app\Models\Traits\CrudTrait;
    use HasFactory;
    use Uuids;

    protected $table = 'check';

    protected $fillable = [
        'company_id',
        'user_id',
        'status',
        'approved_by',
        'check_type_id',
        'summary',
        'task_id',
        'project_id',
        'client_id',
        'date_started',
        'date_ended',
    ];

    public function close(string $dateEnded): void
    {
        $this->update([
            'date_ended' => $dateEnded,
            'status' => CheckStatus::closed(),
        ]);
        $this->updateTimestamps();
    }

}
