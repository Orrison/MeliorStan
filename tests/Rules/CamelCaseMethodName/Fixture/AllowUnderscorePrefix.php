<?php

namespace Orrison\MessedUpPhpstan\Tests\Rules\CamelCaseMethodName\Fixture;

class AllowUnderscorePrefix {
    public function _privateMethod() {}
    public function _helperFunction() {}
}
