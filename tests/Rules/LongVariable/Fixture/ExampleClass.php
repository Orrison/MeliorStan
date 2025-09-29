<?php

namespace Orrison\MeliorStan\Tests\Rules\LongVariable\Fixture;

use Exception;

class ExampleClass
{
    public $veryLongPropertyNameThatExceedsTheMaximumLength;

    public $anotherVeryLongPropertyNameThatIsAlsoTooLong;

    public $validPropertyName;

    public function exampleMethod($veryLongParameterNameThatExceedsTheMaximumLength, $anotherVeryLongParameterNameThatIsAlsoTooLong, $validParameterName)
    {
        $veryLongVariableNameThatExceedsTheMaximumLength = 1;
        $anotherVeryLongVariableNameThatIsAlsoTooLong = 2;
        $validVariableName = 3;

        for ($veryLongLoopVariableNameThatExceedsTheMaximumLength = 0; $veryLongLoopVariableNameThatExceedsTheMaximumLength < 10; $veryLongLoopVariableNameThatExceedsTheMaximumLength++) {
            $anotherVeryLongLoopVariableNameThatIsAlsoTooLong = $veryLongLoopVariableNameThatExceedsTheMaximumLength * 2;
        }

        $items = [1, 2, 3];

        foreach ($items as $veryLongKeyVariableNameThatExceedsTheMaximumLength => $veryLongValueVariableNameThatExceedsTheMaximumLength) {
            $temp = $veryLongValueVariableNameThatExceedsTheMaximumLength;
        }

        try {
            throw new Exception('test');
        } catch (Exception $veryLongExceptionVariableNameThatExceedsTheMaximumLength) {
            $msg = $veryLongExceptionVariableNameThatExceedsTheMaximumLength->getMessage();
        }
    }

    public function methodWithLongParams($validParam, $anotherValidParam)
    {
        return $validParam + $anotherValidParam;
    }
}
