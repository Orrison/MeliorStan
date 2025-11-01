<?php

namespace Fixtures\BooleanArgumentFlag;

class AllOptionsIgnoredClass
{
    public function setFlag(bool $flag)
    {
    }

    public function process(bool $flag)
    {
    }

    public function handle(bool $value)
    {
    }
}

class AllOptionsNotIgnored
{
    public function setOption(bool $value)
    {
    }

    public function handle(bool $flag)
    {
    }

    public function processData(bool $flag)
    {
    }
}

function setConfig(bool $value)
{
}

function processConfig(bool $value)
{
}
