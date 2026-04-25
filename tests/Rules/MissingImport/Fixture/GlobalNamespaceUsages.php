<?php

namespace Orrison\MeliorStan\Tests\Rules\MissingImport\Fixture;

class GlobalNamespaceUsages
{
    public function globalClasses(): void
    {
        $obj = new \stdClass();
        $dt = new \DateTime();
        $e = new \Exception('error');
    }
}
