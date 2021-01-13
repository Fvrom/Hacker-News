<?php

declare(strict_types=1);

require __DIR__ . '/../autoload.php';

if (isset($_POST['title'], $_POST['description'], $_POST['url'])) {
    $title = filter_var($_POST['title'], FILTER_SANITIZE_STRING);
    $description = filter_var($_POST['description'], FILTER_SANITIZE_STRING);
    $postUrl = filter_var($_POST['url'], FILTER_SANITIZE_URL);

    $userId = $_SESSION['user']['id'];
    $postDate = date('Y-m-d H:i:s');

    $_SESSION['successful'] = [];

    $_SESSION['errors'] = [];

    $sql = "INSERT INTO Posts (title, description, post_url, post_date, user_id) VALUES (:title, :postDescription, :postUrl, :postDate, :userId);";
    $statement = $pdo->prepare($sql);

    if (!$statement) {
        die(var_dump($pdo->errorInfo()));
        $_SESSION['errors'][] = "Ops, something went wrong! Try again.";
        redirect("/submit.php");
    }

    $statement->BindParam(':title', $title, PDO::PARAM_STR);
    $statement->BindParam(':postDescription', $description, PDO::PARAM_STR);
    $statement->BindParam(':postUrl', $postUrl, PDO::PARAM_STR);
    $statement->BindParam(':postDate', $postDate, PDO::PARAM_STR);
    $statement->BindParam(':userId', $userId, PDO::PARAM_INT);

    $statement->execute();

    $_SESSION['successful'][] = "Your post has successfully been posted!";

    redirect("/index.php");
} else {
    $_SESSION['errors'][] = "Ops, something went wrong! Try again.";
    redirect("/submit,php");
}
