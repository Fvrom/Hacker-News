<?php

declare(strict_types=1);

require __DIR__ . '/../app/autoload.php'; ?>

<?php


/* For updating profile image */

$userId = $_SESSION['user']['id'];
$username = $_SESSION['user']['username'];
$_SESSION['successful'] = [];
$_SESSION['errors'] = [];


if (isset($_FILES['avatar'])) {

    $avatar = $_FILES['avatar'];
    $avatarName = $_FILES['avatar']['name'];
    $uploadPath = __DIR__ . '/assets/images/' . $avatar['name'];



    if (!in_array($avatar['type'], ['image/jpeg', 'image/jpg', 'image/png'])) {
        $_SESSION['errors'][] = "The uploaded file type is not allowed.";
        redirect("/../settings.php?id=$username");
    }

    if ($avatar['size'] > 2097152) {
        $_SESSION['errors'][] = "The image is too big. Maximum size 2MB.";
        redirect("/../settings.php?id=$username");
    }

    if (count($_SESSION['errors']) === 0) {


        move_uploaded_file($avatar['tmp_name'], $uploadPath);

        /* Upload it in the database */

        uploadImage($pdo, $avatarName, $userId);



        /*fetch the users photo */

        $statement = $pdo->prepare("SELECT avatar FROM Users WHERE id = :id");
        $statement->bindParam(':id', $id, PDO::PARAM_INT);
        $statement->execute();

        if (!$statement) {
            die(var_dump($pdo->errorInfo()));
        }

        $userImage = $statement->fetch(PDO::FETCH_ASSOC);

        $_SESSION['successful'][] = "Image successfully updated.";

        $_SESSION['user']['avatar'] = $userImage;

        redirect('/../settings.php');
    }
}

// To do: Fix so every image is named with unique id to prevent images with same name. 