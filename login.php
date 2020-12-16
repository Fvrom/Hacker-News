<?php require __DIR__ . '/header.php'; ?>


<section class="section-wrap">
    <div class="wrap">
        <h1 class="title-login"> Login here </h1>
        <div class="form-container">
            <form action="users/login.php" method="post">

                <label for="email">Email</label>
                <input type="email" name="email" id="email" placeholder="test@email.com" required>
        </div>

        <div class="form-container">
            <label for="Password">Password</label>
            <input type="password" name="password" id="password" placeholder="Enter password" required>
        </div>


        <button type="submit" class="submit-button"> Login </button>
        </form>
    </div>

</section>

<?php require __DIR__ . '/footer.php';
