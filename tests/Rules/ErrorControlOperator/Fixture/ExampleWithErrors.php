<?php

namespace Orrison\MeliorStan\Tests\Rules\ErrorControlOperator\Fixture;

use stdClass;

class ExampleWithErrors
{
    public function suppressedFunctionCall(): void
    {
        $path = '/tmp/file.txt';
        @unlink($path);
    }

    public function suppressedFileOpen(): mixed
    {
        $file = '/tmp/data.csv';

        return @fopen($file, 'r');
    }

    public function suppressedArrayAccess(): mixed
    {
        $data = ['key' => 'value'];

        return @$data['missing'];
    }

    public function suppressedMethodCall(): mixed
    {
        $obj = new stdClass();

        return @$obj->nonExistentMethod();
    }
}
