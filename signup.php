<?php require __DIR__ . '/app/autoload.php'; ?>
<?php require __DIR__ . '/header.php'; ?>

<section class="sign-up-form">
    <h2> Sign Up </h2>
    <div class="error-container">
        <?php if (isset($_SESSION['errors'])) {  ?>
            <p class="error-message"> <?php errorMessage();
                                        unset($_SESSION['errors']); //delete error message after displayed
                                    } ?> </p>
    </div>

    <div class="sign-up">
        <form name="sign-up-form" action="users/register.php" method="post" onsubmit="return validateForm()">
            <label for="first_name"> First name </label>
            <input type="text" name="first_name" id="first_name" placeholder="First name..." required>

            <label for="last_name"> Last name </label>
            <input type="text" name="last_name" id="last_name" placeholder="Last name..." required>

            <label for="email"> Email </label>
            <input type="email" name="email" id="email" placeholder="Email..." required>

            <label for="username"> Username </label> <span class="username-error"> </span>
            <input type="text" name="username" id="username" class="form-validate" placeholder="Username..." required>

            <label for="password"> Password </label> <span class="password-error"></span>
            <input type="password" name="createPassword" id="createPassword" class="form-validate" placeholder="Password..." required>

            <label for="pwdrepeat"> Repeat password </label>
            <input type="password" name="pwdrepeat" id="pwdrepeat" placeholder="Repeat password..." required>

            <button type="submit" name="submit">Create account</button>

        </form>

    </div>
</section>

<?php

require __DIR__ . '/footer.php'; ?>



<!-- TO DO

Implement Error messages for if user already exists 
-->