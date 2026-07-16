<?php
echo "No heredoc:\n";

$he = 'Bob';
$she = 'Alice';

$text = "$he said, \"PHP is awesome\".
\"Of course.\" $she agreed.\n";

echo $text;

echo "\n With heredoc:\n";

$text = <<<TEXT
$he said "PHP is awesome".
"Of course" $she agreed.\n
TEXT;

echo $text;

$str = <<<IDENTIFIER
    valid
    IDENTIFIER;

echo $str;