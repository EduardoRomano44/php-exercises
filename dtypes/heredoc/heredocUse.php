<?php

$title = 'My site';

// HEREDOC
$header = <<<HEADER
<header>
    <h1>$title</h1>
</header>
HEADER;

// NEWDOC
$text = <<<'IDENTIFIER'
This is my description:
Description
IDENTIFIER;

require "heredocUse.view.php";