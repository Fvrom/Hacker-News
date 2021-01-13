<input type="checkbox" id="hamburger">
<label for="hamburger">
    <nav class="hamburger-nav">
        <ul class="nav-list">
            <li class="nav-item">
                <a href="index.php">Home</a>
            </li>
            <li class="nav-item">
                <a href="trending.php">Trending</a>
            </li>

            <li class="nav-item">
                <a href="submit.php">Submit post</a>
            </li>
            <?php if (isset($_SESSION['user'])) : ?>
                <div class="rightNav">
                    <li class="nav-item">
                        <a href="profile.php?username=<?php echo $_SESSION['user']['username']; ?>"> <?php echo $_SESSION['user']['username']; ?> </a>
                    </li>
                    <li class="nav-item">
                        <a href="/users/logout.php">Sign out</a>
                    </li>
                <?php else : ?>
                    <li class="nav-item">
                        <a href="login.php">login</a>
                    </li>
                    <li class="nav-item">
                        <a href="signup.php">Sign up</a>
                    </li>
                <?php endif; ?>
                </div>
        </ul>
    </nav>
    <button aria-label="Open menu" class="hamburger">
        <svg viewBox="0 0 100 80" width="40" height="25">
            <rect y="10" width="80" height="10"></rect>
            <rect y="35" width="80" height="10"></rect>
            <rect y="60" width="80" height="10"></rect>
        </svg>
    </button>
</label>
