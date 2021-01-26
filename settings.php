<?php require __DIR__ . '/app/autoload.php'; ?>
<?php require __DIR__ . '/header.php'; ?>

<?php
if (isset($_SESSION['user']['username'])) {
    $username = filter_var($_SESSION['user']['username'], FILTER_SANITIZE_STRING);
    $userProfile = getUser($pdo, $username);
    $profileId = $userProfile['id'];
}
?>
<?php if (isset($_SESSION['errors'])) :  ?>
    <p class="error-message"> <?php errorMessage(); ?>
    <?php unset($_SESSION['errors']);  //delete error message after displayed
endif; ?> </p>
    <?php if (isset($_SESSION['successful'])) : ?>
        <p class="error-message"> <?php successfulMessage(); ?>
        <?php unset($_SESSION['successful']);
    endif; ?> </p>
        <?php if (isset($_SESSION['user'])) : ?>
            <section class="settings-section">
                <div class="settings-form">
                    <form action="/users/updateSettings.php" method="post">
                        <div class="settings">
                            <label for="username"> Change username </label>
                            <input type="text" name="username" id="username" placeholder=" <?php echo $userProfile['username']; ?>">
                            <div class="btn-wrapper">
                                <button class="btn-settings" type="submit" class="submit-button"> Change username </button>
                            </div>
                        </div>
                    </form>
                    <form action="/users/updateSettings.php" method="post">
                        <div class="settings">
                            <label for="biography"> Biography </label>
                            <input type="text" name="biography" id="biography" placeholder=" <?php echo $userProfile['biography']; ?>">
                            <div class="btn-wrapper">
                                <button class="btn-settings" type="submit"> Update bio </button>
                            </div>
                        </div>
                    </form>
                    <form action="/users/avatar.php" method="post" enctype="multipart/form-data">
                        <div class="settings">
                            <label for="avatar"> Choose profile image to upload. (Max 2MB) </label>
                            <input type="file" accept="image/jpeg,image/jpg,image/png" name="avatar" id="avatar">
                            <div class="btn-wrapper">
                                <button class="btn-settings" type="submit" class="submit-button"> Update image </button>
                            </div>
                        </div>
                    </form>
                    <form action="/users/updateSettings.php" method="post">
                        <div class="settings">
                            <label for="email"> Change email </label>
                            <input type="email" name="changeEmail" id="changeEmail" placeholder="<?php echo $_SESSION['user']['email']; ?>">
                            <div class="btn-wrapper">
                                <button class="btn-settings" type="submit" class="submit-button"> Change Email</button>
                            </div>
                        </div>
                        <div class="settings">
                    </form>
                    <form action="/users/updateSettings.php" method="post">
                        <div class="settings">
                            <label for="password"> Current password </label>
                            <input type="password" name="currentPwd" id="currentPwd" required>
                            <label for="password"> Change password </label>
                            <input type="password" name="changePwd" id="changePwd">
                            <label for="password"> Repeat new password </label>
                            <input type="password" name="repeatPwd" id="repeatPwd">
                            <div class="btn-wrapper">
                                <button class="btn-settings" type="submit" class="submit-button"> Change password </button>
                            </div>
                        </div>
                    </form>
                    <form action="/users/deleteUser.php?id=<?= $profileId ?>" method="post" id="delete-account-form">
                        <div class="settings">
                            <label for="delete-account" class="form-hidden">delete account</label>
                            <input type="hidden" name="delete-account" value="true">
                            <div class="btn-wrapper">
                                <button type="submit" name="delete-account-btn" id="delete-account-btn" class="btn-settings"> Delete account </button>
                            </div>
                        </div>
                    </form>
                    <div class="settings">
                        <div class="btn-wrapper">
                            <button class="btn-settings"> <a href="profile.php?username=<?php echo $_SESSION['user']['username']; ?>"> Back to your profile </a> </button>
                        </div>
                    </div>

                </div>
            </section>
        <?php endif; ?>
        <?php require __DIR__ . '/footer.php'; ?>
