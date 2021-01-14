<?php

declare(strict_types=1);

require __DIR__ . '/../autoload.php';

$_SESSION['successful'] = [];
$_SESSION['errors'] = [];

/* Update posts */

if (isset($_POST['post_id'], $_POST['title'], $_POST['description'], $_POST['url'])) {
    $postId = (int)$_POST['post_id'];
    $userId = (int)$_SESSION['user']['id'];
    $title = $_POST['title'];
    $description = $_POST['description'];
    $url = $_POST['url'];

    updatePost($pdo, $postId, $userId, $title, $description, $url);

    $_SESSION['successful'][] = "Your post has been updated";

    redirect("/index.php");
} else {
    $_SESSION['errors'][] = "Something went wrong trying to update your post!";
    redirect("/index.php");
}
