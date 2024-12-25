<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Offer extends Model
{

    public function description(): HasOne
    {
        return $this->hasOne(OfferDescription::class);
    }
}
