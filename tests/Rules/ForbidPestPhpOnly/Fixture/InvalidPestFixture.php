<?php

test('basic assertion', function () {
    expect(1 + 1)->toBe(2);
})->only();

it('can run another test', function () {
    expect(true)->toBeTrue();
})->only();

uses()->group('integration')->only();
