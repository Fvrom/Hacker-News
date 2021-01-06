<?php

declare(strict_types=1);


require __DIR__ . '/../autoload.php';



$_SESSION['successful'] = [];
$_SESSION['errors'] = [];



if (isset($_POST['comment'], $_POST['post_id'], $_POST['comment_id'], $_POST['user_comment_id'])) {
    $postId = (int)$_POST['post_id'];
    $commentId = (int)$_POST['comment_id'];
    $userId =  (int)$_POST['user_comment_id'];
    $comment = $_POST['comment'];


    updateComment($pdo, $postId, $userId, $commentId, $comment);

    $_SESSION['successful'][] = "Your comment has been updated";

    redirect('/index.php');
} else {
    $_SESSION['errors'][] = "Something went wrong trying to update your comment!";
    redirect('/index.php');
}
