<?php

declare(strict_types=1);

require __DIR__ . '/../app/autoload.php';

if (isset($_POST['submit'])) {
    $first_name = filter_var($_POST['first_name'], FILTER_SANITIZE_STRING);
    $last_name = filter_var($_POST['last_name'], FILTER_SANITIZE_STRING);
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $username = filter_var($_POST['username'], FILTER_SANITIZE_STRING);
    $createPassword = $_POST['createPassword'];
    $pwdRepeat = $_POST['pwdrepeat'];

    $checkUsernamePattern = preg_match('/^[a-zA-Z0-9]{5,15}$/', $username);

    $_SESSION['errors'] = [];

    // if there's anything other than false, then throw error.
    usernameExists($pdo, $username);
    if ($_SESSION['checkuser']['username'] === $username) {
        $_SESSION['errors'][] = "The username is already taken, please try again!";
        redirect("../signup.php");
    }

    emailExists($pdo, $email);
    if ($_SESSION['checkEmail'] === $email) {
        $_SESSION['errors'][] = "Email already in use";
        redirect("../signup.php");
    }

    /* search parameter to see if username uses any other characters than approved,
    also checks characters length*/
    if ($checkUsernamePattern === 0) {
        $_SESSION['errors'][] = "Obs! Something when wrong with the username. Either it is too short, too long or you have used characters that are not allowed.
        Username can only contain characters from a-z and numbers. The username should be at least 5 characters long and max 15 characters long.";
        redirect("../signup.php");
    }


    /* this is just to be extra sure, there is a safety in user input email in the form */
    if (invalidEmail($email) !== false) {
        $_SESSION['errors'][] = "Invalid Email, please try again.";
        redirect("../signup.php");
        exit(); // stopping the script from running
    }


    if ($createPassword !== $pwdRepeat) {
        $_SESSION['errors'][] = "Paswords did not match";

        redirect("../signup.php");
    }

    createUser($pdo, $username, $first_name, $last_name, $email, $createPassword, $message);
}
