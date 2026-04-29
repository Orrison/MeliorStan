<?php

namespace Orrison\MeliorStan\Tests\Rules\NpathComplexity\Fixture;

class OverflowNpathClass
{
    // 63 sequential if statements produce 2^63 > PHP_INT_MAX, triggering the overflow cap
    public function overflowMethod(int $a): void
    {
        if ($a > 1) {
            echo '1';
        }

        if ($a > 2) {
            echo '2';
        }

        if ($a > 3) {
            echo '3';
        }

        if ($a > 4) {
            echo '4';
        }

        if ($a > 5) {
            echo '5';
        }

        if ($a > 6) {
            echo '6';
        }

        if ($a > 7) {
            echo '7';
        }

        if ($a > 8) {
            echo '8';
        }

        if ($a > 9) {
            echo '9';
        }

        if ($a > 10) {
            echo '10';
        }

        if ($a > 11) {
            echo '11';
        }

        if ($a > 12) {
            echo '12';
        }

        if ($a > 13) {
            echo '13';
        }

        if ($a > 14) {
            echo '14';
        }

        if ($a > 15) {
            echo '15';
        }

        if ($a > 16) {
            echo '16';
        }

        if ($a > 17) {
            echo '17';
        }

        if ($a > 18) {
            echo '18';
        }

        if ($a > 19) {
            echo '19';
        }

        if ($a > 20) {
            echo '20';
        }

        if ($a > 21) {
            echo '21';
        }

        if ($a > 22) {
            echo '22';
        }

        if ($a > 23) {
            echo '23';
        }

        if ($a > 24) {
            echo '24';
        }

        if ($a > 25) {
            echo '25';
        }

        if ($a > 26) {
            echo '26';
        }

        if ($a > 27) {
            echo '27';
        }

        if ($a > 28) {
            echo '28';
        }

        if ($a > 29) {
            echo '29';
        }

        if ($a > 30) {
            echo '30';
        }

        if ($a > 31) {
            echo '31';
        }

        if ($a > 32) {
            echo '32';
        }

        if ($a > 33) {
            echo '33';
        }

        if ($a > 34) {
            echo '34';
        }

        if ($a > 35) {
            echo '35';
        }

        if ($a > 36) {
            echo '36';
        }

        if ($a > 37) {
            echo '37';
        }

        if ($a > 38) {
            echo '38';
        }

        if ($a > 39) {
            echo '39';
        }

        if ($a > 40) {
            echo '40';
        }

        if ($a > 41) {
            echo '41';
        }

        if ($a > 42) {
            echo '42';
        }

        if ($a > 43) {
            echo '43';
        }

        if ($a > 44) {
            echo '44';
        }

        if ($a > 45) {
            echo '45';
        }

        if ($a > 46) {
            echo '46';
        }

        if ($a > 47) {
            echo '47';
        }

        if ($a > 48) {
            echo '48';
        }

        if ($a > 49) {
            echo '49';
        }

        if ($a > 50) {
            echo '50';
        }

        if ($a > 51) {
            echo '51';
        }

        if ($a > 52) {
            echo '52';
        }

        if ($a > 53) {
            echo '53';
        }

        if ($a > 54) {
            echo '54';
        }

        if ($a > 55) {
            echo '55';
        }

        if ($a > 56) {
            echo '56';
        }

        if ($a > 57) {
            echo '57';
        }

        if ($a > 58) {
            echo '58';
        }

        if ($a > 59) {
            echo '59';
        }

        if ($a > 60) {
            echo '60';
        }

        if ($a > 61) {
            echo '61';
        }

        if ($a > 62) {
            echo '62';
        }

        if ($a > 63) {
            echo '63';
        }
    }
}
