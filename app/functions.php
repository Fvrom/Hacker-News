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

/* Functions for signing up */






/* Validating email */
/* TO DO  Go further and see if email aldready exists */
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

    $_SESSION['checkEmail'] = $checkEmail;

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
    /* $_SESSION['successful'] = $message;
 
    echo $message; */
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

/* Delete this?!
function updateUserSession($pdo, $statement, $updatedUser, $id)
{
    $statement = $pdo->prepare("SELECT * FROM users WHERE id = :id");
    $statement->BindParam(':id', $id);
    $statement->execute();

    $updatedUser = $statement->fetch(PDO::FETCH_ASSOC);
    unset($updatedUser['password']);
    $_SESSION['user'] = $updatedUser;
} */

/***** Posts  *****/

function getUserPosts($pdo, int $profileId)
{
    $_SESSION['errors'] = [];

    $statement = $pdo->prepare("SELECT Posts.id, title, description, post_url, post_date, user_id FROM Posts
    INNER JOIN Users
    ON Posts.user_id = Users.id
    WHERE Users.id = :id
    ORDER BY Posts.id DESC");

    $statement->BindParam(':id', $profileId, PDO::PARAM_INT);
    $statement->execute();

    $userPosts = $statement->fetchAll(PDO::FETCH_ASSOC);

    if (!$userPosts) {
        return $_SESSION['errors'][] = "No posts yet.";
    }

    return $userPosts;
}


/** Get comments from Posts  **/
// WORK IN PROGRESS 
function getPostsComments($pdo, int $postId)
{
    $_SESSION['errors'] = [];

    $statement = $pdo->prepare("SELECT Comments.*, Users.username FROM Comments 
    INNER JOIN Users 
    ON Comments.user_id = Users.id
    WHERE post_id = :postId
    ORDER BY Comments.post_id DESC");

    $statement->BindParam(':postId', $postId, PDO::PARAM_INT);
    $statement->execute();

    $userComments = $statement->fetchAll(PDO::FETCH_ASSOC);

    if (!$userComments) {
        return $_SESSION['errors'][] = "No posts yet.";
    }

    return $userComments;
}

/** Count comments **/

function countComments($pdo, int $postId)
{
    $statement = $pdo->prepare('SELECT COUNT(*) FROM Comments WHERE post_id = :postId');

    $statement->bindParam(':postId', $postId, PDO::PARAM_INT);
    $statement->execute();

    $comments = $statement->fetch(PDO::FETCH_ASSOC);

    return $comments['COUNT(*)'];
}

/*
SELECT users.id FROM users
INNER JOIN posts
ON users.id = posts.author
WHERE users.id = 1;
*/

/** All posts  **/

function getAllPosts($pdo, $allPosts)
{

    $_SESSION['errors'] = [];

    $statement = $pdo->prepare("SELECT * FROM Posts
    ORDER BY Posts.post_date DESC");

    $statement->execute();

    $allPosts = $statement->fetchAll(PDO::FETCH_ASSOC);


    if (!$allPosts) {
        return  $_SESSION['errors'][] = "Ops, could not find posts";
    }

    return $allPosts;
}

function getPostbyId($pdo, $postId)
{
    $_SESSION['errors'] = [];

    $statement = $pdo->prepare("SELECT * FROM Posts WHERE id = :postId");
    $statement->bindParam(':postId', $postId);
    $statement->execute();

    $post = $statement->fetch(PDO::FETCH_ASSOC);

    if (!$post) {
        return  $_SESSION['errors'][] = "Ops, could not find any post";
    }

    return $post;
}

/*** Upload photo  ***/

function uploadImage($pdo, $avatar, $id)
{

    $statement = $pdo->prepare("UPDATE Users SET avatar = :avatar WHERE id = :id");
    $statement->BindParam(':avatar', $avatar['name'], PDO::PARAM_STR);
    $statement->BindParam(':id', $id, PDO::PARAM_INT);
    $statement->execute();
}
