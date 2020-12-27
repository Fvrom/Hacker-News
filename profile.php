<?php require __DIR__ . '/app/autoload.php'; ?>
<?php require __DIR__ . '/header.php'; ?>

<?php if (isset($_SESSION['errors'])) {  ?>
    <p class="error-message"> <?php errorMessage();
                                unset($_SESSION['errors']); //delete error message after displayed
                            } ?> </p>

    <?php


    if (isset($_GET['username'])) {
        $username = filter_var($_GET['username'], FILTER_SANITIZE_STRING);

        $userProfile = getUser($pdo, $username);

        $profileId = $userProfile['id'];
        $userPosts = getUserPosts($pdo, $profileId);
    }

    ?>




    <section>

        <article class="profile-container">
            <div class="profile-page">
                <div class="profile-img-container">
                    <!-- <img src="<?php $userProfile['avatar']; ?>" class="profile-img" alt="User profile"> -->
                </div>
                <h1 class="profile-title"><?php echo $userProfile['username']; ?> </h1>
                <p class="biography"> <?php echo $userProfile['biography']; ?> </p>
            </div>

            <?php // Check if user logged in is the owner of this profile page. 
            // If it is, show button for settings. 

            if ($profileId === $_SESSION['user']['id']) : ?>

                <button class="edit-profile">Edit profile</button>

            <?php endif; ?>
        </article>

        <!-- TO DO: 
        Javascript eventlistener for button. Redirect to settings page. 
        Settings page: upload profle photo
        Edit bio, username . 
            -->





        <h2 class="u-posts"> Posts </h2>

        <?php foreach ($userPosts as $userPost) : ?>

            <article class="user-posts">
                <div class="posts-wrapper">
                    <div class="post-item">
                        <h3 class="post-title"> <?php echo $userPost['title']; ?> </h3>
                    </div>
                    <div class="post-item">
                        <p class="post-description"> <?php echo $userPost['description']; ?> </p>
                    </div>
                    <div class="post-item">
                        <a href="<?php echo $userPost['post_url'] ?> "> <?php echo $userPost['post_url']; ?> </a>
                    </div>
                    <div class="post-item-author">
                        <p> Posted by: <?php echo $userPost['user_id']; ?> </p>

                    </div>
                    <div class="post-item-date">
                        <p> <?php echo $userPost['post_date']; ?> </p>
                    </div>
                </div>
                <?php if ($profileId === $_SESSION['user']['id']) : ?>

                    <button class="edit-post">Edit post</button>

                <?php endif; ?>

            </article>


        <?php endforeach; ?>



    </section>


    <?php require __DIR__ . '/footer.php'; ?>