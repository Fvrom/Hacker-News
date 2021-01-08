<?php require __DIR__ . '/app/autoload.php'; ?>
<?php require __DIR__ . '/header.php'; ?>

<?php if (isset($_SESSION['errors'])) {  ?>
    <p class="error-message"> <?php errorMessage();
                                unset($_SESSION['errors']); //delete error message after displayed
                            } ?> </p>
    <div class="successful-container">
        <?php if (isset($_SESSION['successful'])) {  ?>
            <p class="successful-message"> <?php successfulMessage();
                                            unset($_SESSION['successful']); //delete error message after displayed
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

                        <a href="settings.php?username=<?php echo $_SESSION['user']['username']; ?> "> <button class="edit-profile">Edit profile</button> </a>

                    <?php endif; ?>
                </article>

                <!-- TO DO: 
        Javascript eventlistener for button. Redirect to settings page. 
        Settings page: upload profle photo
        Edit bio, username . 
            -->





                <h2 class="u-posts"> Posts </h2>
                <?php if (is_array($userPosts)) : ?>
                    <?php foreach ($userPosts as $userPost) : ?>
                        <?php $postId = $userPost['id'];

                        $countLikes = countLikes($pdo, $postId);
                        $countComments = countComments($pdo, $postId);
                        $userComments = getPostsComments($pdo, $postId);
                        ?>


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
                            <div class="post-item-date">
                                <a href="comments.php?id=<?php echo $postId; ?> "> Comments </a>
                                <?php echo $countComments; ?>
                            </div>

                            <div>

                                <p> Likes
                                    <?php echo $countLikes; ?> </p>
                                <form action="/app/posts/likes.php" method="post">

                                    <input type="hidden" name="post-id" id="post-id" value="<?php echo $postId ?>">
                                    <button type="submit"> Like </button>
                                </form>
                            </div>



                            <?php if ($profileId === $_SESSION['user']['id']) : ?>

                                <button class="edit-post">Edit post</button>

                                <!-- This is gonna be hidden until button clicked -->
                                <form class="form-hidden" action="/app/posts/update.php" method="post">

                                    <input type="hidden" name="post_id_edit" id="post_id_edit" value="<?php echo $postId ?>">

                                    <label for="title"> Title </label>
                                    <input type="text" name="title" id="title" placeholder="<?php echo $userPost['title']; ?> " required>

                                    <label for="description"> Description </label>
                                    <input type="text" name="description" id="description" placeholder="<?php echo $userPost['description']; ?>" required>

                                    <label for="url"> Url to the post </label>
                                    <input type="url" name="url" id="url" placeholder=" <?php echo $userPost['post_url']; ?>"" required>

                            <button type=" submit"> Update post </button>
                                </form>

                                <form class="form-hidden" action="/app/posts/delete.php" method="post">
                                    <?php echo $postId; ?>
                                    <input type="hidden" name="post_id_delete" id="post_id_delete" value="<?php echo $postId ?>">


                                    <button type="submit"> Delete post </button>
                                </form>


                            <?php endif; ?>

                        </article>


                    <?php endforeach; ?>
                <?php endif; ?>



            </section>


            <?php require __DIR__ . '/footer.php'; ?>