<?php
function dump($data)
{
    echo '<pre>';
    var_dump($data);
    echo '</pre>';
}

function dump_and_die($data)
{
    dump($data);
    die();
}

$balance = 100;

dump($balance);

$message = 'Insufficient balance';

dump_and_die($message);

echo "Won't show, it's already dead";