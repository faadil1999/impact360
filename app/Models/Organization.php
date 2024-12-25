<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Organization extends Model
{


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
