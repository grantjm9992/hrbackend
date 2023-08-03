<?php

declare(strict_types=1);

namespace App\Models\CoreContext;

use App\Traits\Uuids;
use App\ValueObject\UserRole;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Cashier\Billable;
use Laravel\Sanctum\HasApiTokens;
use PHPOpenSourceSaver\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject
{
    use HasApiTokens;
    use HasFactory;
    use Notifiable;
    use Billable;
    use Uuids;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'surname',
        'email',
        'password',
        'user_role',
        'company_id',
        'role_id',
        'email_confirmed',
    ];

    protected $appends = [
        'title',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'email_confirmed',
        'created_at',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims(): array
    {
        return [];
    }

    public function getTitleAttribute(): string
    {
        return $this->name . ' ' . $this->surname;
    }

    public function delete(): void
    {
        $this->update([
            'deleted_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);
    }

    public function userRoles(): HasMany
    {
        return $this->hasMany(UserUserRoles::class);
    }

    public function getUserRoleArray(): array
    {
        $returnArray = [];
        foreach ($this->userRoles()->get()->toArray() as $role) {
            $returnArray[] = $role['user_role'];
        }
        return $returnArray;
    }
}
