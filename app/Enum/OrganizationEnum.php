<?php

namespace App\Enum;

use App\Traits\Enums\Names;
use App\Traits\Enums\Values;

enum OrganizationEnum: string
{
    use Names, Values;

    case PENDING = 'pending';
    case ACTIVE = 'active';
    case REJECTED = 'rejected';
}
