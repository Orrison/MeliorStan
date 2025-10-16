<?php

if (false) {
    test('basic assertion', function () {
        expect(1 + 1)->toBe(2);
    });

    it('can run another test', function () {
        expect(true)->toBeTrue();
    });

    uses()->group('integration');
}
