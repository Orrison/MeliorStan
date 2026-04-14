<?php

namespace Orrison\MeliorStan\Tests\Rules\DevelopmentCodeFragment\Fixture;

class CustomFunctionsFixture
{
    public function withDump(): void
    {
        $data = ['key' => 'value'];
        dump($data);
    }

    public function withDd(): void
    {
        $data = ['key' => 'value'];
        dd($data);
    }

    public function withCustomDebugFunction(): void
    {
        $data = ['key' => 'value'];
        my_custom_debug($data);
    }

    public function withVarDumpNowAllowed(): void
    {
        $data = ['key' => 'value'];
        var_dump($data);
    }

    public function validCode(): void
    {
        $data = [1, 2, 3];
        $count = count($data);
        echo $count;
    }
}
