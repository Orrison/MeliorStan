<?php

class NonPestOnlyUsageFixture
{
    public function demonstrate(): void
    {
        $collection = new class () {
            public function only(): void {}

            public function filter(): self
            {
                return $this;
            }
        };

        $collection->only();
        $collection->filter()->only();
    }

    public function useProperty(): void
    {
        $helper = new class () {
            public function only(): void {}
        };

        $this->callOnly($helper);
    }

    protected function callOnly(object $object): void
    {
        if (method_exists($object, 'only')) {
            $object->only();
        }
    }
}
