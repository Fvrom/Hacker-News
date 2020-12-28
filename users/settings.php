<?php

$_SESSION['errors'] = [];

if (isset($_FILES['avatar'])) {
    $avatar = $_FILES['avatar'];
}

if (!in_array($avatar['type'], ['image/jpeg', 'image/jpg', 'image/png'])) {
    $_SESSION['errors'][] = "The uploaded file type is not allowed.";
    redirect('/settings.php');
}

if ($avatar['size'] > 2000000) {
    $_SESSION['errors'][] = "The image is too big. Maximum size 2MB.";
}

if (count($_SESSION['errors']) === 0) {
    $uploadPath = __DIR__ . '/uploads' . $avatar['name'];

    move_uploaded_file($avatar['tmp_name'], $uploadPath);
}

?>

<?php if (isset($_SESSION['errors'])) {  ?>
    <p class="error-message"> <?php errorMessage();
                                unset($_SESSION['errors']); //delete error message after displayed
                            } ?> </p>



    <form action="/" method="post" enctype="multipart/form/data">

        <div>
            <label for="avatar"> Choose profile image to upload </label>
            <input type="file" accept=".jpg, .jpeg, .png" name="avatar" id="avatar">
        </div>

    </form>