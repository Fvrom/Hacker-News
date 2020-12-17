<?php

declare(strict_types=1);

// function for redirecting pages
function redirect(string $path)
{
    header("Location: /index.php");
    exit;
}

/* Functions for signing up */ 

/* Function validates username */ 
function invalidUsername($username)
{

    /* search parameter to see if username uses any other characters than approved*/
    if (!preg_match("/^[a-zA-Z0-9]*$/", $username)) {
        $result = true; /* True actually means it is not approved */
    } else {
        $result = false;  /* False is good */
    }
    return $result;
}

/* Validating email */ 

function invalidEmail($email)
{
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $result = true; /* return true if it did not pass filter */
    } else {
        $result = false;
    }
    return $result;
}

/* Validating password */ 

function pwdMatch()