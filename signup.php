<?php require __DIR__ . '/app/autoload.php'; ?>
<?php require __DIR__ . '/header.php'; ?>

<section class="sign-up-form">
    <h2> Sign Up </h2>
    <div class="sign-up">
        <form action="users/register.php" method="post">
            <input type="text" name="first_name" placeholder="First name..." required>
            <input type="text" name="last_name" placeholder="Last name..." required>
            <input type="email" name="email" placeholder="Email..." required>
            <input type="text" name="username" placeholder="Username..." required>
            <input type="password" name="password" placeholder="Password..." required>
            <input type="password" name="pwdrepeat" placeholder="Repeat password..." required>
            <button type="submit" name="submit">Sign Up</button>

        </form>

    </div>
</section>

<?php

require __DIR__ . '/footer.php'; ?>



<!-- TO DO

Implement Error messages for if user already exists 
-->