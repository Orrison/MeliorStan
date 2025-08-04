<?php

namespace Orrison\MessedUpPhpstan\Tests\Rules\ShortProperty\Fixture;

class ExampleClass
{
    public $x;

    public $id;

    public $validPropertyName;

    public $anotherValidProperty;

    protected $validProtectedProperty;

    private $validPrivateProperty;

    public function exampleMethod($validParameterName, $anotherValidParam)
    {
        $validVariableName = 1;
        $anotherVar = 2;

        return $validParameterName + $anotherValidParam;
    }
}

class AnotherClass
{
    public $y;

    public $validProperty;

    private $z;
}

trait ExampleTrait
{
    public $traitProperty;

    public $a;
}
