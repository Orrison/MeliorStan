<?php

namespace Orrison\MeliorStan\Tests\Rules\MissingImport\Fixture;

class ExceptionsFqcnUsages
{
    public function allowedClass(): void
    {
        $obj = new \App\Services\SomeService();
    }

    public function notAllowedClass(): void
    {
        $obj = new \App\Models\User();
    }
}
