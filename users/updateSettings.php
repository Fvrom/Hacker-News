<?php

declare(strict_types=1);

require __DIR__ . '/../app/autoload.php'; ?>

<?php
$userId = $_SESSION['user']['id'];
$username = $_SESSION['user']['username'];
// Backend for the settings part.

if (isset($_POST['username'])) {
    $username = $_POST['username'];
    $changeUsername = filter_var($_POST['username'], FILTER_SANITIZE_STRING);
    $userId = $_SESSION['user']['id'];
    $checkUsernamePattern = preg_match('/^[a-zA-Z0-9]{5,15}$/', $changeUsername);

    usernameExists($pdo, $changeUsername);
    if ($_SESSION['checkuser']['username'] === $changeUsername) {
        $_SESSION['errors'][] = "The username is already taken, please try again!";
        redirect("/../settings.php?username=$username");
    }

    if ($checkUsernamePattern === 0) {
        $_SESSION['errors'][] = "Obs! Something when wrong with the username. Either it is too short, too long or you have used characters that are not allowed.
        Username can only contain characters from a-z and numbers. The username should be at least 5 characters long and max 15 characters long.";
        redirect("/../settings.php?username=$username");
    }

    $statement = $pdo->prepare('UPDATE Users SET username = :changeUsername WHERE id = :userId');
    $statement->BindParam(':userId', $userId, PDO::PARAM_INT);
    $statement->BindParam(':changeUsername', $changeUsername, PDO::PARAM_STR);
    $statement->execute();

    if (!$statement) {
        die(var_dump($pdo->errorInfo()));
    }

    $_SESSION['successful'][] = "Updated profile!";

    $_SESSION['user']['username'] = $changeUsername;


    redirect("/../settings.php?username=$username");
}

if (isset($_POST['biography'])) {
    $updateBiography = filter_var($_POST['biography'], FILTER_SANITIZE_STRING);

    $statement = $pdo->prepare('UPDATE Users SET biography = :updateBiography WHERE id = :id');
    $statement->BindParam(':id', $userId, PDO::PARAM_INT);
    $statement->BindParam(':updateBiography', $updateBiography, PDO::PARAM_STR);
    $statement->execute();

    if (!$statement) {
        die(var_dump($pdo->errorInfo()));
    }

    $_SESSION['successful'][] = "Updated biography!";

    $_SESSION['user']['biography'] = $updateBiography;

    redirect("/../settings.php?username=$username");
}


if (isset($_POST['changeEmail'])) {
    $changeEmail = $_POST['changeEmail'];

    /* this is just to be extra sure, there is a safety in user input email in the form */
    if (invalidEmail($changeEmail) !== false) {
        $_SESSION['errors'][] = "Invalid Email, please try again.";
        redirect("/../settings.php?username=$username");
    }

    emailExists($pdo, $changeEmail);

    if ($_SESSION['checkEmail'] === $changeEmail) {
        return $_SESSION['errors'][] = "Email already in use";
        redirect("/../settings.php?username=$username");
    }

    $statement = $pdo->prepare('UPDATE Users SET email = :changeEmail WHERE id = :id;');
    $statement->BindParam(':id', $userId, PDO::PARAM_INT);
    $statement->BindParam(':changeEmail', $changeEmail, PDO::PARAM_STR);
    $statement->execute();

    if (!$statement) {
        die(var_dump($pdo->errorInfo()));
    }

    $_SESSION['successful'][] = "Email updated!";
    $_SESSION['user']['email'] = $changeEmail;

    redirect("/../settings.php?username=$username");
}

if (isset($_POST['currentPwd'], $_POST['changePwd'], $_POST['repeatPwd'])) {
    $currentPwd = $_POST['currentPwd'];
    $changePwd = $_POST['changePwd'];
    $repeatPwd = $_POST['repeatPwd'];


    if ($changePwd !== $repeatPwd) {
        $_SESSION['errors'][] = "Paswords did not match";

        redirect("/../settings.php?username=$username");
    }

    getUserPwd($pdo, $userId);

    if (password_verify($currentPwd, $_SESSION['user']['password'])) {
        unset($_SESSION['user']['password']);

        $hashedNewPwd = password_hash($changePwd, PASSWORD_DEFAULT);

        $statement = $pdo->prepare('UPDATE Users SET password = :hashedNewPwd WHERE id = :id;');
        $statement->BindParam(':id', $userId, PDO::PARAM_INT);
        $statement->BindParam(':hashedNewPwd', $hashedNewPwd, PDO::PARAM_STR);
        $statement->execute();

        if (!$statement) {
            die(var_dump($pdo->errorInfo()));
        }

        $_SESSION['successful'][] = "Password updated!";


        redirect("/../settings.php?username=$username");
    }
}
