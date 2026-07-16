<?php

function sum()
{
    $numbers = func_get_args();
    $total = 0;
    for ($i = 0; $i < count($numbers); $i++) {
        $total += $numbers[$i];
    }

    return $total;
}

function sum2(?int ...$numbers): int
{
    $total = 0;
    for ($i = 0; $i < count($numbers); $i++){
        $total += $numbers[$i];
    }

    return $total;
}

echo sum(10, 20) . "\n"; // 30
echo sum(10, 20, 30) . "\n"; // 60
echo sum() . "\n";
echo sum2(10, 20) . "\n"; // 30
echo sum2(10, 20, 30) . "\n"; // 60
echo sum2(null) . "\n";