<?php require __DIR__ . '/app/autoload.php';

// Backend for the settings part. 

/* For updating profile iamge */

$id = $_SESSION['user']['id'];
$username = $_SESSION['user']['username'];
$_SESSION['successful'] = [];
$_SESSION['errors'] = [];

if (isset($_FILES['avatar'])) {




    $avatar = $_FILES['avatar'];

    $uploadPath = __DIR__ . '/assets/images' . $avatar['name'];



    if (!in_array($avatar['type'], ['image/jpeg', 'image/jpg', 'image/png'])) {
        $_SESSION['errors'][] = "The uploaded file type is not allowed.";
        redirect('/settings.php');
    }

    if ($avatar['size'] > 2000000) {
        $_SESSION['errors'][] = "The image is too big. Maximum size 2MB.";
        redirect('/settings.php');
    }

    if (count($_SESSION['errors']) === 0) {


        move_uploaded_file($avatar['tmp_name'], $uploadPath);

        /* Upload it in the database */

        uploadImage($pdo,  $avatar, $id);



        /*fetch the users photo */
        $statement = $pdo->prepare("SELECT avatar FROM Users WHERE id = :id");
        $statement->bindParam(':id', $id, PDO::PARAM_INT);
        $statement->execute();

        $userImage = $statement->fetch(PDO::FETCH_ASSOC);

        $_SESSION['successful'][] = "Image successfully updated.";

        redirect('/settings.php');
    }
}


if (isset($_POST['username'], $_POST['biography'])) {

    $changeUsername = filter_var($_POST['username'], FILTER_SANITIZE_STRING);

    $updateBiography = filter_var($_POST['biography'], FILTER_SANITIZE_STRING);

    usernameExists($pdo, $changeUsername);
    if ($_SESSION['checkuser']['username'] === $changeUsername) {

        $_SESSION['errors'][] = "The username is already taken, please try again!";
        redirect("../settings.php");
    }

    $statement = $pdo->prepare('UPDATE Users SET username = :changeUsername, biography = :updateBiograpghy, WHERE id = :id;');
    $statement->BindParam(':id', $id, PDO::PARAM_INT);
    $statement->BindParam(':changeUsername', $changeUsername, PDO::PARAM_STR);
    $statement->BindParam(':updateBiography', $updateBiography, PDO::PARAM_STR);
    $statement->execute();

    $_SESSION['successful'][] = "Updated profile!";
    redirect('/settings.php');
}


if (isset($_POST['changeEmail'], $_POST['currentPwd'], $_POST['changePwd'], $_POST['repeatPwd'])) {

    $changeEmail = $_POST['changeEmail'];
    $currentPwd = $_POST['currentPwd'];
    $changePwd = $_POST['changePwd'];
    $repeatPwd = $_POST['repeatPwd'];

    $email = $_SESSION['user']['email'];

    getUserPwd($pdo, $id);

    if (password_verify($currentPwd, $_SESSION['pwd'])) {

        unset($_SESSION['pwd']);


        emailExists($pdo, $changeEmail);

        if ($_SESSION['checkEmail'] === $changeEmail) {
            return $_SESSION['errors'][] = "Email already in use";
            redirect('/settings.php');
        }
    }
}
/* Lägg till statements för ny mail, nytt lösen. Bör jag göra dessa separat? */
