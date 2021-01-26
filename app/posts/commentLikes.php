<?php

declare(strict_types=1);

require __DIR__ . '/../autoload.php';

if (isset($_POST['comment-id'])) {
    $userId = $_SESSION['user']['id'];
    $postId = $_GET['id'];
    $commentId = $_POST['comment-id'];

    $_SESSION['errors'] = [];

    $isCommentLikedByUser = isCommentLikedByUser($pdo, $commentId, $userId);

    if (!$isCommentLikedByUser) {
        $statement = $pdo->prepare("INSERT INTO Comment_likes (comment_id, user_id) VALUES (:commentId, :userId);");

        $statement->BindParam(':commentId', $commentId, PDO::PARAM_INT);
        $statement->BindParam(':userId', $userId, PDO::PARAM_INT);

        $statement->execute();

        redirect("/comments.php?id=$postId");
    } else {
        /* If user has liked and press like again it deletes the like */
        $statement = $pdo->prepare("DELETE FROM Comment_likes WHERE comment_id = :commentId AND user_id = :userId;");

        $statement->BindParam(':commentId', $commentId, PDO::PARAM_INT);
        $statement->BindParam(':userId', $userId, PDO::PARAM_INT);

        $statement->execute();

        redirect("/comments.php?id=$postId");
    }
}
