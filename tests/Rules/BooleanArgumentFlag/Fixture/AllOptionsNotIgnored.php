<?php

namespace Fixtures\BooleanArgumentFlag;

class AllOptionsNotIgnored
{
    public function setOption(bool $value) {}

    public function handle(bool $flag) {}

    public function processData(bool $flag) {}
}
