<?php

namespace Orrison\MeliorStan\Tests\Rules\ExcessiveClassComplexity\Fixture;

class HighComplexityClass
{
    // Complexity: 11
    public function processOrder(int $status): void
    {
        if ($status > 0) {
            if ($status > 10) {
                echo 'high';
            } elseif ($status > 5) {
                echo 'mid';
            }
        } elseif ($status < 0) {
            while ($status < 0) {
                $status++;
            }
        }

        for ($i = 0; $i < 3; $i++) {
            echo $i;
        }

        foreach ([1, 2] as $v) {
            echo $v;
        }

        $x = $status > 0 ? 'yes' : 'no';
        $y = $status ?? 0;

        if ($status === 100) {
            echo 'exact';
        }
    }

    // Complexity: 11
    public function validatePayment(int $amount): bool
    {
        if ($amount > 0) {
            if ($amount > 1000) {
                return false;
            } elseif ($amount > 500) {
                return true;
            }
        } elseif ($amount < 0) {
            while ($amount < 0) {
                $amount++;
            }
        }

        for ($i = 0; $i < 3; $i++) {
            echo $i;
        }

        foreach ([1, 2] as $v) {
            echo $v;
        }

        $flag = $amount > 0 ? true : false;
        $value = $amount ?? 0;

        if ($amount === 100) {
            return true;
        }

        return false;
    }

    // Complexity: 11
    public function calculateTotal(int $qty, int $price): int
    {
        if ($qty > 0) {
            if ($qty > 100) {
                return $qty * $price;
            } elseif ($qty > 50) {
                return $qty * $price;
            }
        } elseif ($qty < 0) {
            while ($qty < 0) {
                $qty++;
            }
        }

        for ($i = 0; $i < 3; $i++) {
            echo $i;
        }

        foreach ([1, 2] as $v) {
            echo $v;
        }

        $result = $qty > 0 ? $qty * $price : 0;
        $total = $result ?? 0;

        if ($qty === 1) {
            return $price;
        }

        return $total;
    }

    // Complexity: 11
    public function applyDiscount(int $total, int $code): int
    {
        if ($total > 0) {
            if ($total > 200) {
                return $total - 20;
            } elseif ($total > 100) {
                return $total - 10;
            }
        } elseif ($total < 0) {
            while ($total < 0) {
                $total++;
            }
        }

        for ($i = 0; $i < 3; $i++) {
            echo $i;
        }

        foreach ([1, 2] as $v) {
            echo $v;
        }

        $discounted = $code > 0 ? $total * 0.9 : $total;
        $result = $discounted ?? $total;

        if ($code === 999) {
            return 0;
        }

        return (int) $result;
    }

    // Complexity: 11
    public function generateReport(int $period, int $type): string
    {
        if ($period > 0) {
            if ($period > 365) {
                return 'annual';
            } elseif ($period > 30) {
                return 'quarterly';
            }
        } elseif ($period < 0) {
            while ($period < 0) {
                $period++;
            }
        }

        for ($i = 0; $i < 3; $i++) {
            echo $i;
        }

        foreach ([1, 2] as $v) {
            echo $v;
        }

        $label = $type > 0 ? 'summary' : 'detail';
        $result = $label ?? 'none';

        if ($type === 0) {
            return 'default';
        }

        return $result;
    }
}
