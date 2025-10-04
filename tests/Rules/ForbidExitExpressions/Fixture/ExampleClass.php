<?php

namespace Orrison\MeliorStan\Tests\Rules\ForbidExitExpressions\Fixture;

class ExampleClass
{
    public function methodWithExit(): void
    {
        if (someCondition()) {
            exit;
        }
    }

    public function methodWithExitCode(): void
    {
        exit(1);
    }

    public function methodWithExitMessage(): void
    {
        exit('Error occurred');
    }

    public function methodWithDie(): void
    {
        die('Fatal error');
    }

    public function methodWithDieCode(): void
    {
        die(1);
    }

    public function methodWithoutExit(): void
    {
        echo 'No exit here';
    }

    public function methodWithMultipleExits(): void
    {
        if (condition1()) {
            exit;
        }

        if (condition2()) {
            die('Error');
        }
    }
}
