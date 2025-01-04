<?php

namespace App\Models;

use App\Enum\OrganizationEnum;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Organization extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'status',
        'user_id',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<int, string>
     */
    protected $casts = [
        'status' => OrganizationEnum::class,
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
}
