<?php

require __DIR__ . '/../app/autoload.php';

if (isset($_POST['submit'])) {

    $first_name = filter_var($_POST['first_name'], FILTER_SANITIZE_STRING);
    $last_name = filter_Var($_POST['last_name'], FILTER_SANITIZE_STRING);
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $username = filter_var($_POST['username'], FILTER_SANITIZE_STRING);
    $createpPassword = $_POST['createPassword'];
    $pwdRepeat = $_POST['pwdrepeat'];







    if ($password != $pwdRepeat) {
        $_SESSION['error'] = "Pasword did not match";
        redirect("../signup.php");
    } else redirect("../index.php");



    // if there's anything other than false, then throw error. 

    if (invalidUserName($username) !== false) {
        redirect("../signup.php?error=invalidusername");
        exit; // stopping the script from running
    }

    /* createUser($pdo, $username, $first_name, $last_name, $email, $password);
} else {
    redirect("/index.php");
} */


    if (invalidEmail($email) !== false) {
        header("location: ../signup.php?error=invalidemail");
        exit(); // stopping the script from running
    }


    if (pwdMatch($password, $pwdRepeat) !== false) {
        header("location: ../signup.php?error=passworddontmatch");
        exit(); // stopping the script from running
    }




    if (usernameExists($pdo, $username) !== false) {
        header("location: ../signup.php?error=usernametaken");
        exit(); // stopping the script from running
    }


    if (emailExists($pdo, $email) !== false) {
        header("location: ../signup.php?error=emailtaken");
        exit(); // stopping the script from running
    }

    createUser($pdo, $username, $first_name, $last_name, $email, $password);
} else {
    header("location: ../signup.php");
    echo "Did not work, try again";
    exit(); // stopping the script from running
}
