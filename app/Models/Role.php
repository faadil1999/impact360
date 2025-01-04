<?php

namespace App\Models;

use App\Enum\Space;
use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Models\Role as RoleSpatie;

class Role extends RoleSpatie
{
    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'space' => Space::class
    ];


    /**
     * Return the super-Admin.
     *
     * @return Role
     */
    static function getSuperAdmin(): Role
    {
        return self::withoutGlobalScopes()->where('name', 'Super-Admin')->first();
    }

    /**
     * Return the organization Founder.
     *
     * @return Role
     */
    static function getOrganizationFounder(): Role
    {
        return self::withoutGlobalScopes()->where('name', 'Founder')->first();
    }

    /**
     * Return the organization member.
     *
     * @return Role
     */
    static function getOrganizationMember(): Role
    {
        return self::withoutGlobalScopes()->where('name', 'member')->first();
    }

    /**
     * Return the beneficiary.
     *
     * @return Role
     */
    static function getBeneficiary(): Role
    {
        return self::withoutGlobalScopes()->where('name', 'beneficiary')->first();
    }
}
