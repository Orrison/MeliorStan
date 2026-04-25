<?php

namespace Orrison\MeliorStan\Tests\Rules\MissingImport\Fixture;

use App\Contracts\HasLabel;
use App\Models\User;
use App\Services\SomeService;

enum EnumImportedUsages: string implements HasLabel
{
    case Active = 'active';

    public function label(SomeService $service): User
    {
        return new User();
    }
}
