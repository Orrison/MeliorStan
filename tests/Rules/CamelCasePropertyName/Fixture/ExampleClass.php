<?php

namespace Orrison\MessedUpPhpstan\Tests\Rules\CamelCasePropertyName\Fixture;

class ExampleClass
{
    // Valid
    public $validProperty;
    public $anotherValidProperty;
    public $httpResponse;

    // Invalid for default config
    public $invalid_property;
    public $InvalidProperty;
    public $HTTPResponseInvalid;
}
