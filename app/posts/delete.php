<?php

declare(strict_types=1);


require __DIR__ . '/../autoload.php';




$_SESSION['successful'] = [];
$_SESSION['errors'] = [];

if (isset($_POST['post_id'], $_POST['comment_id'], $_POST['user_id_delete_comment'])) {
    $postId = (int)$_POST['post_id'];
    $commentId = (int)$_POST['comment_id'];
    $userId =  (int)$_POST['user_id_delete_comment'];


    deleteComment($pdo, $postId, $userId, $commentId);

    $_SESSION['successful'][] = "Your comment has been deleted";

    redirect('/index.php');
} else {
    $_SESSION['errors'][] = "Something went wrong trying to delete yourr post!";
    redirect('/index.php');
}
