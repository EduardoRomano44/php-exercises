<?php

$title = "Hello, World!"; // Variable
const SUBTITLE = 'This is PHP'; // Constant
if (SUBTITLE != null){
    /* 
        Also constant, but works on run-time
    */
    define('PARAGRAPH', '^This was a constant');
}

require 'hello.view.php';