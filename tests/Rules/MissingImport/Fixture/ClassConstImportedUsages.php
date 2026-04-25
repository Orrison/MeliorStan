<?php

namespace Orrison\MeliorStan\Tests\Rules\MissingImport\Fixture;

use App\Models\User;

class ClassConstImportedUsages
{
    public const User|null THE_USER = null;
}
