<?php

namespace Orrison\MeliorStan\Tests\Rules\ForbidGotoStatements\Fixture;

class ExampleClass
{
    public function methodWithGoto(): void
    {
        $i = 0;

        start:
        echo $i;
        $i++;

        if ($i < 5) {
            goto start;
        }
    }

    public function methodWithMultipleGotos(): void
    {
        goto label1;

        label1:
        goto label2;

        label2:
        echo 'Done';
    }

    public function methodWithoutGoto(): void
    {
        echo 'No goto here';
    }

    public function gotoInLoop(): void
    {
        for ($i = 0; $i < 10; $i++) {
            if ($i === 5) {
                goto end;
            }
        }

        end:
        echo 'Finished';
    }
}
