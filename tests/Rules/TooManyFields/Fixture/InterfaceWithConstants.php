<?php

namespace Orrison\MeliorStan\Tests\Rules\TooManyFields\Fixture;

// Interfaces have no instance fields, should never trigger
interface InterfaceWithConstants
{
    public const string STATUS_ACTIVE = 'active';

    public const string STATUS_INACTIVE = 'inactive';

    public const string STATUS_PENDING = 'pending';

    public function process(): void;
}
