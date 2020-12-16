<?php

declare(strict_types=1);

// function for redirecting pages
function redirect(string $path)
{
    header("Location: /index.php");
    exit;
}
