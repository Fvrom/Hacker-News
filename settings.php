<?php require __DIR__ . '/app/autoload.php'; ?>
<?php require __DIR__ . '/header.php'; ?>

<?php


if (isset($_GET['username'])) {
    $username = filter_var($_GET['username'], FILTER_SANITIZE_STRING);

    $userProfile = getUser($pdo, $username);

    $profileId = $userProfile['id'];
}

?>

<?php if (isset($_SESSION['errors'])) {  ?>
    <p class="error-message"> <?php errorMessage();
                                unset($_SESSION['errors']); //delete error message after displayed
                            } ?> </p>


    <?php if (isset($_SESSION['successful'])) {  ?>
        <p class="error-message"> <?php successfulMessage();
                                    unset($_SESSION['successful']);
                                } ?> </p>


        <?php
        if ($profileId === $_SESSION['user']['id']) : ?>

            <!-- check this, do i have to take out everything in the function for the email ? -->
            <section class="sign-up-form">
                <?php
                echo $_SESSION['checkEmail'];
                ?>

                <form action="/users/settings.php" method="post">
                    <div class="sign-up">
                        <label for="username"> Change username </label>
                        <input type="text" name="username" id="username" placeholder=" <?php echo $userProfile['username']; ?>">

                        <label for="biography"> Biography </label>
                        <input type="text" name="biography" id="biography" placeholder=" <?php echo $userProfile['biography']; ?>">
                        <button type="submit"> Update profile</button>


                    </div>
                </form>

                <form action="/users/settings.php" method="post" enctype="multipart/form/data">

                    <div class="sign-up">
                        <label for="avatar"> Choose profile image to upload. (Max 2MB) </label>
                        <input type="file" accept=".jpg, .jpeg, .png" name="avatar" id="avatar">
                        <button type="submit" class="submit-button"> Update image </button>
                    </div>

                </form>

                <form action="/users/settings.php" method="post">
                    <div class="sign-up">
                        <label for="email"> Change email </label>
                        <input type="email" name="changeEmail" id="changeEmail" placeholder="<?php echo $_SESSION['user']['email']; ?>">
                        <button type="submit" class="submit-button"> Change Email</button>
                    </div>
                    <div class="sign-up">

                        <label for="password"> Current password </label>
                        <input type="password" name="currentPwd" id="currentPwd" required>

                        <label for="password"> Change password </label>
                        <input type="password" name="changePwd" id="changePwd">

                        <label for="password"> Repeat new password </label>
                        <input type="password" name="repeatPwd" id="repeatPwd">
                        <button type="submit" class="submit-button"> Change password </button>
                    </div>

                    <div class="sign-up">
                        <a href="profile.php?username=<?php echo $_SESSION['user']['username']; ?>"> <?php echo $_SESSION['user']['username']; ?> "><button class="submit-button"> Back to your profile </button> </a>
                    </div>
                </form>
            <?php endif; ?>
            </section>