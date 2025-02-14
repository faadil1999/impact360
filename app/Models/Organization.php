<?php

namespace App\Models;

use App\Enum\OrganizationStatusEnum;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Organization extends Model
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, HasRoles;

    protected $guarded = [];

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'status',
        'user_id',
        'organization_type_id',
        'organization_sub_type_id'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<int, string>
     */
    protected $casts = [
        'status' => OrganizationStatusEnum::class,
    ];

    /**
     * Function for getting the description of Organization
     *
     * @return HasOne
     */
    public function description(): HasOne
    {
        return $this->hasOne(OrganizationDescription::class);
    }

    /**
     * Function for getting the organization type
     *
     * @return BelongsTo
     */
    public function Type(): BelongsTo
    {
        return $this->belongsTo(OrganizationType::class);
    }

    /**
     * Function for getting the organization sub type
     *
     * @return BelongsTo
     */
    public function SubType(): BelongsTo
    {
        return $this->belongsTo(OrganizationSubType::class);
    }
}
