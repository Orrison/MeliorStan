<?php

namespace Orrison\MessedUpPhpstan\Tests\Rules\ShortParameter\Fixture;

class ExampleClass
{
    public $validPropertyName;

    public $anotherProperty;

    public $x;

    public function __construct($validConstructorParam)
    {
        $this->validPropertyName = $validConstructorParam;
    }

    public function exampleMethod($a, $id, $validParameterName)
    {
        $validVariableName = 1;
        $anotherVar = 2;

        return $a + $id + $validParameterName;
    }

    public static function staticMethod($validStaticParam, $b)
    {
        return $validStaticParam + $b;
    }

    public function methodWithShortParams($x, $y, $validParam)
    {
        return $x + $y + $validParam;
    }

    public function methodWithOnlyValidParams($validParam1, $validParam2, $anotherValidParam)
    {
        return $validParam1 + $validParam2 + $anotherValidParam;
    }
}

function globalFunction($c, $validGlobalParam)
{
    return $c + $validGlobalParam;
}
