<?php

namespace App\Enum;

use App\Traits\Enums\Names;
use App\Traits\Enums\Values;

enum Space: string
{
    use Names, Values;

    case Admin = 'admin';
    case Founder = 'founder';
    case Member = 'member';
    case Beneficiary = 'beneficiary';
    case Contributor = 'contributor';
    case Actor = 'actor';
    case OrganizationActor = 'organization-actor';
    case OrganizationContributror = 'organization-contributor';
}
