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

        <article class="profile-page">
            <div class="profile-img-container">
                <!-- <img src="<?php $userProfile['avatar']; ?>" class="profile-img" alt="User profile"> -->
            </div>
            <h1 class="profile-title"><?php echo $userProfile['username']; ?> </h1>
            <p class="biography"> <?php echo $userProfile['biography']; ?> </p>
        </article>

        <h2 class="u-posts"> Posts </h2>

        <article class="user-posts">
            <div class="posts-wrapper">
                <div class="post-item">
                    <h3 class="post-title"> <?php echo $userPosts['title']; ?> </h3>
                </div>
                <div class="post-item">
                    <p class="post-description"> <?php echo $userPosts['description']; ?> </p>
                </div>
                <div class="post-item">
                    <a href="<?php echo $userPosts['post_url'] ?> "> <?php echo $userPosts['post_url']; ?> </a>
                </div>
                <div class="post-item-author">
                    <p> Posted by: <?php echo $userPosts['user_id']; ?> </p>

                </div>
                <div class="post-item-date">
                    <p> <?php echo $userPosts['post_date']; ?> </p>
                </div>
            </div>
        </article>
        <!-- TO DO: 
        Get user from database. 
        Display 
        - profile picture
         - bio
         - posts made by the user
-->


    </section>


    <?php require __DIR__ . '/footer.php'; ?>