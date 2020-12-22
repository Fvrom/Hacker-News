<?php

declare(strict_types=1);

require __DIR__ . '/../app/autoload.php';


if (isset($_POST['email'], $_POST['password'])) {
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);

    $_SESSION['errors'] = [];
    /* $pdo = new PDO($dBPath);
    //die(var_dump($pdo->errorInfo()));
    if (!$pdo) {
        die("Connection failed: " . (var_dump($pdo_errorInfo())));
    } */  // New Pdo fixed in autoload

    // print_R($statement->errorInfo()) -> run error details

    $statement = $pdo->prepare("SELECT * FROM users WHERE email = :email");
    $statement->BindParam(':email', $email);
    $statement->execute();

    //Fetching user as an array
    $user = $statement->fetch(PDO::FETCH_ASSOC); // Get the user in an array. 

    if (!$user) {
        $_SESSION['errors'][] = "User not found";
        redirect('/login.php');
    }

    if (password_verify($_POST['password'], $user['password'])) {

        unset($user['password']);

        $_SESSION['user'] = $user; // Set a session variable for the user. 

        // If password is correct we save the user in the session. 
        // we do not store password in session. 
        redirect('/index.php');
    } else {
        $_SESSION['errors'][] = "Incorrect password";
        redirect('/login.php');
    }
}
