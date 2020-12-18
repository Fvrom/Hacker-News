<?php

declare(strict_types=1);

// function for redirecting pages
function redirect(string $path)
{
    header("Location: ${path}");
    exit;
} 

/* Functions for signing up */

/* Function validates username 
function invalidUsername($username)
{
    $result = true;
    /* search parameter to see if username uses any other characters than approved
    if (!preg_match("/^[a-zA-Z0-9]*$/", $username)) {
        $result = true; /* True actually means it is not approved 
    } else {
        $result = false;  /* False is good 
    }
    return $result;
}


/* Validating email */
/* TO DO  Go further and see if email aldready exists 
function invalidEmail($email)
{
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $result = true; /* return true if it did not pass filter 
    } else {
        $result = false;
    }
    return $result;
}

/* Validating password

function pwdMatch($password, $pwdRepeat)
{
    if ($password !== $pwdRepeat) {
        $result = true; /* True means it is not a match  
    } else {
        $result = false; /* False means it is a match 
    }
    return $result;
}

function usernameExists($pdo, $username)
{

    $statement = $pdo->prepare('SELECT COUNT(username) AS num FROM Users WHERE username = :username;');
    $statement->BindParam(':username', $username);
    $statement->execute();

    // check if user exists 
    $row = $statement->fetch(PDO::FETCH_ASSOC);

    if ($row['num'] > 0) {
        die('That username already exists!');
    }
}

function emailExists($pdo, $email)
{


    $statement = $pdo->prepare('SELECT COUNT(email) AS num FROM Users WHERE email = :email;');
    $statement->BindParam(':email', $email);
    $statement->execute();

    // check if user exists 
    $row = $statement->fetch(PDO::FETCH_ASSOC);

    if ($row['num'] > 0) {
        die('Email already exists!');
    }
}

/* 
    if ($statement->rowCount() == 1) {
        return false;
        die('Email already registred!');
    }
    else {
        return true;
    } */ // By documentation this does not seem to be the best way because its behaviour may not be relied upon. 
/*
function createUser($pdo, $username, $first_name, $last_name, $email, $password)
{


    $sql = "INSERT INTO Users (username, first_name, last_name, email, password) VALUES (:username, :first_name, :last_name, :email, :password);";
    $statement = $pdo->prepare($sql);

    $hashedPwd = password_hash($password, PASSWORD_DEFAULT);

    $statement->BindParam(':username', $username);
    $statement->BindParam(':first_name', $first_name);
    $statement->BindParam(':last_name', $last_name);
    $statement->BindParam(':email', $email);
    $statement->BindParam(':password', $hashedPwd);



    $statement->execute();

    //redirect("/index.php");
    exit();
} */
