<?php

namespace Orrison\MeliorStan\Tests\Rules\DevelopmentCodeFragment\Fixture;

class ExampleClass
{
    public function withVarDump(): void
    {
        $data = ['key' => 'value'];
        var_dump($data);
    }

    public function withPrintR(): void
    {
        $data = ['key' => 'value'];
        print_r($data);
    }

    public function withDebugZvalDump(): void
    {
        $data = 'test';
        debug_zval_dump($data);
    }

    public function withDebugPrintBacktrace(): void
    {
        debug_print_backtrace();
    }

    public function withDd(): void
    {
        $data = ['key' => 'value'];
        dd($data);
    }

    public function withDump(): void
    {
        $data = ['key' => 'value'];
        dump($data);
    }

    public function withRay(): void
    {
        $data = ['key' => 'value'];
        ray($data);
    }

    public function validCode(): void
    {
        $data = [1, 2, 3];
        $count = count($data);
        $mapped = array_map(fn ($item) => $item * 2, $data);
        echo $count;
        echo($mapped[0]);
    }
}
