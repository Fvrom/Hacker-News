<?php require __DIR__ . '/app/autoload.php'; ?>
<?php require __DIR__ . '/header.php'; ?>


<section class="log-in-section">
    <div class="log-in-container">
        <?php if (isset($_SESSION['errors'])) {  ?>
            <p class="error-message"> <?php errorMessage();
                                        unset($_SESSION['errors']); //delete error message after displayed
                                    } ?> </p>

            <h2 class="title-form"> Login here </h2>
            <form class="login-form" action="/users/login.php" method="post">

                <div class="log-in">
                    <label for="email">Email</label>
                </div>
                <div class="submit">
                    <input type="email" name="email" id="email" placeholder="test@email.com" required>
                </div>

                <div class="log-in">
                    <label for="password">Password</label>
                </div>
                <div class="submit">
                    <input type="password" name="password" id="password" placeholder="Enter password" required>
                </div>

                <div class="btn-wrapper">
                    <button type="submit" class="login-button"> Login </button>
                </div>


            </form>
    </div>

</section>

<?php require __DIR__ . '/footer.php';
