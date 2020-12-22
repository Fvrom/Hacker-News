<nav>

    <ul>
        <li>
            <a href="newest.php">new</a>
        </li>
        <li>
            <a href="newestcomments.php">comments</a>
        </li>
        <li>
            <a href="update.php">submit</a>
        </li>

        <?php if (isset($_SESSION['user'])) : ?>

            <li>
                <a href="/profile.php"> <?php echo $_SESSION['username']; ?> </a>
            </li>

            <?php if (isset($_SESSION['user'])) : ?>

                <li>
                    <a href="/users/logout.php">logout</a>
                </li>
            <?php endif; ?>



        <?php else : ?>
            <li>
                <a href="login.php">login</a>
            </li>

            <li>
                <a href="signup.php">Sign up</a>
            </li>

        <?php endif; ?>


    </ul>
</nav>