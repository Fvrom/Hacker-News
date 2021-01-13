<?php require __DIR__ . '/app/autoload.php'; ?>
<?php require __DIR__ . '/header.php'; ?>

<section class="log-in-section">


    <div class="sign-up-container">

        <h2 class="title-form"> Sign Up </h2>
        <div class="error-container">
            <?php if (isset($_SESSION['errors'])) {  ?>
                <p class="error-message"> <?php errorMessage();
                                            unset($_SESSION['errors']); //delete error message after displayed
                                        } ?> </p>
        </div>
        <form class="login-form" name="sign-up-form" action="users/register.php" method="post">

            <div class="log-in">
                <label for="first_name"> First name </label>
            </div>
            <div class="submit">
                <input type="text" name="first_name" id="first_name" placeholder="First name..." required>
            </div>
            <div class="log-in">
                <label for="last_name"> Last name </label>
            </div>
            <div class="submit">
                <input type="text" name="last_name" id="last_name" placeholder="Last name..." required>
            </div>
            <div class="log-in">
                <label for="email"> Email </label>
            </div>
            <div class="submit">
                <input type="email" name="email" id="email" placeholder="Email..." required>
            </div>

            <div class="log-in">
                <label for="username"> Username (Minimum 5 characters) </label> <span class="username-error"> </span>
            </div>
            <div class="submit">
                <input type="text" name="username" id="username" class="form-validate" placeholder="Username..." required>
            </div>
            <div class="log-in">
                <label for="password"> Password </label> <span class="password-error"></span>
            </div>
            <div class="submit">
                <input type="password" name="createPassword" id="createPassword" class="form-validate" placeholder="Password..." required>
            </div>
            <div class="log-in">
                <label for="pwdrepeat"> Repeat password </label>
            </div>
            <div class="submit">
                <input type="password" name="pwdrepeat" id="pwdrepeat" placeholder="Repeat password..." required>
            </div>

            <div class="btn-wrapper">
                <button class="btn-sign-up" type="submit" name="submit">Create account</button>
            </div>

        </form>

    </div>
</section>

<?php

require __DIR__ . '/footer.php'; ?>



<!-- TO DO

Implement Error messages for if user already exists
-->
