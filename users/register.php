<?php

if (isset($_POST['submit'])) {

    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $email = $_POST['email'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    $pwdRepeat = $_POST['pwdrepeat'];



    require __DIR__ . '../database/newsdatabase.db';
    require __DIR__ . '../app/functions.php';

    // if there's anything other than false, then throw error. 

    if (invalidUserName($username) !== false) {
        header("location: ../signup.php?error=invalidusername");
        exit(); // stopping the script from running
    }
    if (invalidEmail($email) !== false) {
        header("location: ../signup.php?error=invalidemail");
        exit(); // stopping the script from running
    }


    if (pwdMatch($password, $pwdRepeat) !== false) {
        header("location: ../signup.php?error=passworddontmatch");
        exit(); // stopping the script from running
    }



    /* Need to fix this one, connect to database */
    if (usernameExists($dbPath, $username) !== false) {
        header("location: ../signup.php?error=usernametaken");
        exit(); // stopping the script from running
    }

    createUser($databaseconenction, $username, $first_name, $last_name, $email, $password);
} else {
    header("location: ../signup.php");
    exit(); // stopping the script from running
}
