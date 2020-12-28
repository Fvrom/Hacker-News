<?php require __DIR__ . '/app/autoload.php'; ?>
<?php require __DIR__ . '/header.php'; ?>

<?php
$_SESSION['errors'] = [];


if (isset($_GET['username'])) {
    $username = filter_var($_GET['username'], FILTER_SANITIZE_STRING);

    $userProfile = getUser($pdo, $username);

    $profileId = $userProfile['id'];
}


if (isset($_FILES['avatar'])) {
    $avatar = $_FILES['avatar'];

    $uploadPath = __DIR__ . '/assets/images' . $avatar['name'];

    $id = $_SESSION['user']['id'];

    if (!in_array($avatar['type'], ['image/jpeg', 'image/jpg', 'image/png'])) {
        $_SESSION['errors'][] = "The uploaded file type is not allowed.";
        redirect('/settings.php');
    }

    if ($avatar['size'] > 2000000) {
        $_SESSION['errors'][] = "The image is too big. Maximum size 2MB.";
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
    }
}

?>

<?php if (isset($_SESSION['errors'])) {  ?>
    <p class="error-message"> <?php errorMessage();
                                unset($_SESSION['errors']); //delete error message after displayed
                            } ?> </p>


    <?php
    if ($profileId === $_SESSION['user']['id']) : ?>

        <form action="/" method="post" enctype="multipart/form/data">

            <div>
                <label for="avatar"> Choose profile image to upload </label>
                <input type="file" accept=".jpg, .jpeg, .png" name="avatar" id="avatar">
                <button type="submit" class="submit-button"> Update </button>
            </div>

        </form>



    <?php endif; ?>