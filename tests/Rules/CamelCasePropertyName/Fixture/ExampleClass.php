<?php

namespace Orrison\MessStan\Tests\Rules\CamelCasePropertyName\Fixture;

class ExampleClass
{
    public $isHttpResponse;

    public $is_http_response;

    public $IsHttpResponse;

    public $isHTTPResponse;

    public $IsHTTPResponse;

    public $ISHTTPRESPONSE;

    public $_isHttpResponse;

    public $_isHTTPResponse;
}
