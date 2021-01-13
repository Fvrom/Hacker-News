<?php

declare(strict_types=1);

// function for redirecting pages
function redirect(string $path)
{
    header("Location: ${path}");
    exit;
}

/* throws error message */
function errorMessage()
{
    if (isset($_SESSION['errors'])) {
        foreach ($_SESSION['errors'] as $error) {
            echo $error;
        }
    }
}

/* throws successful message */
function successfulMessage()
{
    if (isset($_SESSION['successful'])) {
        foreach ($_SESSION['successful'] as $success) {
            echo $success;
        }
    }
}
/*****Functions for signing up *****/
/* Validating email */
function invalidEmail($email)
{
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $result = true; /* return true if it did not pass filter */
    } else {
        $result = false;
    }
    return $result;
}

/* Check database for existing username */
function usernameExists($pdo, $username)
{
    $statement = $pdo->prepare('SELECT username FROM Users WHERE username = :username;');
    $statement->BindParam(':username', $username, PDO::PARAM_STR);
    $statement->execute();

    // check if user exists
    $checkUser = $statement->fetch(PDO::FETCH_ASSOC);

    $_SESSION['checkuser'] = $checkUser;

    if (!$statement) {
        die(var_dump($pdo->errorInfo()));
    }

    /* unset($_SESSION['password']);
    unset($_SESSION['email']);
    unset($_SESSION['first_name']);
    unset($_SESSION['last_name']);
    unset($_SESSION['avatar']);
    unset($_SESSION['biography']); */ // don't need? vi plockar bara ut username.
}

/* check database for existing email */
function emailExists($pdo, $email)
{
    $statement = $pdo->prepare('SELECT email FROM Users WHERE email = :email;');
    $statement->BindParam(':email', $email);
    $statement->execute();

    // check if user exists
    $checkEmail = $statement->fetch(PDO::FETCH_ASSOC);

    $_SESSION['checkEmail'] = $checkEmail['email'];

    return $_SESSION['checkEmail'];
}




function createUser($pdo, $username, $first_name, $last_name, $email, $password, $message)
{
    $_SESSION['successful'] = [];

    $sql = "INSERT INTO Users (username, first_name, last_name, email, password) VALUES (:username, :first_name, :last_name, :email, :password);";
    $statement = $pdo->prepare($sql);
    if (!$statement) {
        die(var_dump($pdo->errorInfo()));
    }

    $hashedPwd = password_hash($password, PASSWORD_DEFAULT);

    $statement->BindParam(':username', $username);
    $statement->BindParam(':first_name', $first_name);
    $statement->BindParam(':last_name', $last_name);
    $statement->BindParam(':email', $email);
    $statement->BindParam(':password', $hashedPwd);

    $statement->execute();

    $_SESSION['successful'][] = "Your account has been created! You can now log in.";

    redirect("/index.php");
}

/** Function for Profile page */

function getUser($pdo, $username)
{
    $_SESSION['errors'] = [];

    $statement = $pdo->prepare("SELECT id, username, avatar, biography FROM Users WHERE username = :username");
    $statement->BindParam(':username', $username, PDO::PARAM_STR);
    $statement->execute();

    $userProfile =  $statement->fetch(PDO::FETCH_ASSOC);

    if (!$userProfile) {

        return $_SESSION['errors'][] = "Something went wrong with this profile!";
    }

    return $userProfile;
}

function getUserPwd($pdo, $id)
{
    $statement = $pdo->prepare("SELECT password FROM Users WHERE id = :id");
    $statement->BindParam(':id', $id, PDO::PARAM_STR);
    $statement->execute();

    $userPwd = $statement->fetch(PDO::FETCH_ASSOC);

    if (!$userPwd) {

        return $_SESSION['errors'][] = "Something went wrong with finding password!";
    }

    $_SESSION['pwd'] = $userPwd;

    return $_SESSION['pwd'];
}

/***** Posts  *****/

function getUserPosts($pdo, int $profileId)
{
    $_SESSION['errors'] = [];

    $statement = $pdo->prepare("SELECT Posts.*, Users.username FROM Users
    INNER JOIN Posts
    ON Posts.user_id = Users.id
    WHERE Users.id = :id
    ORDER BY Posts.post_date DESC");

    $statement->BindParam(':id', $profileId, PDO::PARAM_INT);
    $statement->execute();

    $userPosts = $statement->fetchAll(PDO::FETCH_ASSOC);

    if (!$userPosts) {
    } else

        return $userPosts;
}
/** All posts  **/

function getAllPosts($pdo, $allPosts)
{
    $_SESSION['errors'] = [];

    $statement = $pdo->prepare("SELECT Posts.*, Users.username FROM Users
    INNER JOIN Posts ON Posts.user_id = Users.id
    ORDER BY post_date DESC");

    $statement->execute();

    $allPosts = $statement->fetchAll(PDO::FETCH_ASSOC);


    if (!$allPosts) {
        return  $_SESSION['errors'][] = "Ops, could not find posts";
    }

    return $allPosts;
}

/* Get a specific post */
function getPostbyId($pdo, $postId)
{
    $_SESSION['errors'] = [];

    $statement = $pdo->prepare("SELECT Posts.*, Users.username FROM Users
    INNER JOIN Posts
    ON Posts.user_id = Users.id
    WHERE Posts.id = :postId");

    $statement->bindParam(':postId', $postId);
    $statement->execute();

    $post = $statement->fetch(PDO::FETCH_ASSOC);

    if (!$post) {
        return  $_SESSION['errors'][] = "Ops, could not find any post";
    }

    return $post;
}

/** Get comments from Posts  **/
function getPostsComments($pdo, $postId)
{
    $_SESSION['errors'] = [];

    $statement = $pdo->prepare("SELECT Comments.*, Users.username FROM Comments
    INNER JOIN Users
    ON Comments.user_id = Users.id
    WHERE post_id = :postId
    ORDER BY Comments.comment_date DESC");

    $statement->BindParam(':postId', $postId, PDO::PARAM_INT);
    $statement->execute();

    $userComments = $statement->fetchAll(PDO::FETCH_ASSOC);

    if (!$userComments) {
    } else {
        return $userComments;
    }
}

/** Count comments **/

function countComments($pdo, $postId)
{
    $statement = $pdo->prepare('SELECT COUNT(*) FROM Comments WHERE post_id = :postId');

    $statement->bindParam(':postId', $postId, PDO::PARAM_INT);
    $statement->execute();

    $comments = $statement->fetch(PDO::FETCH_ASSOC);

    return $comments['COUNT(*)'];
}

/** Likes **/

function countLikes($pdo, $postId)
{
    $statement = $pdo->prepare('SELECT COUNT(*) FROM Likes WHERE post_id = :postId');
    $statement->bindParam(':postId', $postId, PDO::PARAM_INT);
    $statement->execute();

    $likes = $statement->fetch(PDO::FETCH_ASSOC);

    return $likes['COUNT(*)'];
}

/** Get trending posts **/

function topLikes($pdo)
{
    $statement = $pdo->query('SELECT COUNT(Likes.post_id) AS votes, Posts.*, Users.username FROM Likes
    INNER JOIN Posts
    ON Posts.id = Likes.post_id
    INNER JOIN Users
    ON Posts.user_id = Users.id
    GROUP BY
    Posts.id
    ORDER BY COUNT(1) DESC
    LIMIT 10;
   ');

    $statement->execute();

    $topLikes = $statement->fetchAll(PDO::FETCH_ASSOC);

    return $topLikes;
}

/* Check if post is like by user */
function isLikedByUser($pdo, $postId, $userId)
{
    $statement = $pdo->prepare('SELECT * FROM Likes WHERE post_id = :postId
    AND user_id = :userId;');

    $statement->bindParam(':postId', $postId);
    $statement->bindParam(':userId', $userId);

    $statement->execute();

    $isLikedByUser = $statement->fetch(PDO::FETCH_ASSOC);

    return $isLikedByUser;
}


/*** Upload photo  ***/

function uploadImage($pdo, $avatarName, $userId)
{
    $statement = $pdo->prepare("UPDATE Users SET avatar = :avatar WHERE id = :userId");
    $statement->BindParam(':avatar', $avatarName, PDO::PARAM_STR);
    $statement->BindParam(':userId', $userId, PDO::PARAM_INT);
    $statement->execute();
}

/***** Update functions *****/

/* update comments*/

function updateComment($pdo, int $postId, int $userId, int $commentId, string $comment)
{
    $sql = "UPDATE Comments SET comment = :comment WHERE comment_id = :commentId AND post_id = :postId AND user_id = :userId;";
    $statement = $pdo->prepare($sql);
    $statement->bindParam(':comment', $comment);
    $statement->bindParam(':commentId', $commentId);
    $statement->bindParam(':postId', $postId);
    $statement->bindParam(':userId', $userId);

    $statement->execute();
}

/* Update posts */

function updatePost($pdo, int $postId, int $userId, string $title, string $description, string $url)
{
    $sql = "UPDATE Posts SET title = :title,
    description = :description,
    post_url = :url
    WHERE id = :postId AND user_id = :userId;";
    $statement = $pdo->prepare($sql);
    $statement->bindParam(':title', $title);
    $statement->bindParam(':description', $description);
    $statement->bindParam(':url', $url);
    $statement->bindParam(':postId', $postId);
    $statement->bindParam(':userId', $userId);

    $statement->execute();
}

/***** Delete functions *****/

/* Delete comment */

function deleteComment($pdo, int $postId, int $userId, int $commentId)
{
    $statement = $pdo->prepare("DELETE FROM Comments WHERE post_id = :postId AND comment_id = :commentId AND user_id = :userId;");

    $statement->BindParam(':postId', $postId);
    $statement->bindParam(':commentId', $commentId);
    $statement->BindParam(':userId', $userId);

    $statement->execute();
}

/* Delete post */

function deletePost($pdo, int $postId, int $userId)
{
    $statement = $pdo->prepare("DELETE FROM Posts WHERE id = :postId AND user_id = :userId;
    DELETE FROM Comments WHERE post_id = :postId;
    DELETE FROM Likes WHERE post_id = :postId;
    ");

    $statement->bindParam(':postId', $postId, PDO::PARAM_INT);
    $statement->bindParam(':userId', $userId, PDO::PARAM_INT);

    $statement->execute();
    if (!$statement) {
        die(var_dump($pdo->errorInfo()));
    }
}
