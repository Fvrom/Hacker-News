<?php require __DIR__ . '/app/autoload.php'; ?>
<?php require __DIR__ . '/header.php'; ?>

<?php if (isset($_SESSION['errors'])) : ?>
    <p class="error-message"> <?php errorMessage(); ?>
    <?php unset($_SESSION['errors']); //delete error message after displayed
endif; ?>
    </p>
    <div class="successful-container">
        <?php if (isset($_SESSION['successful'])) :  ?>
            <p class="successful-message"> <?php successfulMessage(); ?>
            <?php unset($_SESSION['successful']); //delete error message after displayed
        endif; ?> </p>
    </div>
    <?php
    if (isset($_GET['username'])) {
        $username = filter_var($_GET['username'], FILTER_SANITIZE_STRING);
        $userProfile = getUser($pdo, $username);
        $userImage = $userProfile['avatar'];
        $profileId = $userProfile['id'];
        $userPosts = getUserPosts($pdo, $profileId);
    } ?>
    <?php if (isset($_SESSION['user'])) : ?>
    <?php $userId = $_SESSION['user']['id'];
    endif; ?>

    <a name="top"></a>
    <section>
        <article class="profile-container">
            <div class="profile-page">
                <div class="profile-img-container">
                    <?php if ($userImage === null) : ?>
                        <img src="/users/assets/images/robot-02-icon.webp" alt="User profile">
                    <?php else : ?>
                        <img src="/users/assets/images/<?php echo $userImage; ?>" alt="User profile">
                    <?php endif; ?>
                </div>
                <h1 class="profile-title"><?php echo $userProfile['username']; ?> </h1>
                <p class="biography"> <?php echo $userProfile['biography']; ?> </p>
            </div>
            <?php // Check if user logged in is the owner of this profile page.
            // If it is, show button for settings.
            if (isset($_SESSION['user'])) : ?>
                <?php if ($profileId === $_SESSION['user']['id']) : ?>
                    <a href="settings.php?username=<?php echo $_SESSION['user']['username']; ?> "> <button class="edit-profile">Edit profile</button> </a>
                <?php endif; ?>
            <?php endif; ?>
        </article>
        <h2 class="user-posts-title"> Posts </h2>

        <?php if (!is_array($userPosts)) : ?>
            <div class="comments-wrapper">
                <div class="post-item">
                    <p> No posts yet! </p>
                </div>
            </div>
        <?php endif; ?>

        <?php if (is_array($userPosts)) : ?>
            <?php foreach ($userPosts as $userPost) : ?>
                <?php $postId = $userPost['id'];

                $countLikes = countLikes($pdo, $postId);
                $countComments = countComments($pdo, $postId);
                $userComments = getPostsComments($pdo, $postId);
                ?>
                <article class="home-page">
                    <div class="posts-wrapper">
                        <div class="post-item-author">
                            <p> By: <?php echo $userPost['username']; ?> ,
                                <?php echo $userPost['post_date']; ?> </p>
                        </div>
                        <div class="post-item">
                            <h3 class="post-title"> <?php echo $userPost['title']; ?> </h3>
                        </div>
                        <div class="post-item">
                            <p class="post-description"> <?php echo $userPost['description']; ?> </p>
                        </div>
                        <div class="post-item-url">
                            <a href="<?php echo $userPost['post_url'] ?> "> Get to article here </a>
                        </div>
                        <div class="info-wrapper">
                            <div class="post-item-comment">
                                <a href="comments.php?id=<?php echo $userPost['id']; ?> "> <?php echo $countComments; ?> Comments </a>
                            </div>
                            <div class="post-item-like">
                                <form action="/app/posts/likes.php" method="post">
                                    <p> <?php echo $countLikes; ?> Likes
                                        <?php if (isset($_SESSION['user'])) : ?>
                                            <?php $isLikedByUser = isLikedByUser($pdo, $postId, $userId); ?>
                                            <?php if (is_array($isLikedByUser)) : ?>
                                                <input type="hidden" name="post-id" id="post-id" value="<?php echo $userPost['id'] ?>">
                                                <button class="unlike-button" type="submit"> Unlike </button>
                                            <?php else : ?>
                                                <input type="hidden" name="post-id" id="post-id" value="<?php echo $userPost['id'] ?>">
                                                <button class="like-button" type="submit"> Like </button>
                                            <?php endif; ?>
                                        <?php endif; ?>
                                    </p>
                                </form>
                            </div>
                        </div>
                        <?php if (isset($_SESSION['user'])) : ?>
                            <?php if ($profileId === $_SESSION['user']['id']) : ?>
                                <div class="edit-wrapper">
                                    <button class="edit-post">Edit post</button>
                                    <!-- This is gonna be hidden until button clicked -->
                                    <form class="form" action="/app/posts/updatepost.php" method="post">
                                        <input type="hidden" name="post_id" id="post_id" value="<?php echo $userPost['id']; ?>">
                                        <div>
                                            <label for="title"> Title </label>
                                        </div>
                                        <input type="text" name="title" id="title" placeholder="<?php echo $userPost['title']; ?> " required>
                                        <div>
                                            <label for="description"> Description </label>
                                        </div>
                                        <input type="text" name="description" id="description" placeholder="<?php echo $userPost['description']; ?>" required>
                                        <div>
                                            <label for="url"> Url to the post </label>
                                        </div>
                                        <input type="url" name="url" id="url" placeholder=" <?php echo $userPost['post_url']; ?>"" required>

                                <div class=" button-wrapper">
                                        <div>
                                            <button type=" submit"> Update post </button>
                                        </div>
                                    </form>
                                    <form class="form" action="/app/posts/delete.php" method="post">
                                        <input type="hidden" name="post_id_delete" id="post_id_delete" value="<?php echo $postId ?>">
                                        <div>
                                            <button type="submit"> Delete post </button>
                                        </div>

                                    </form>
                                </div>
                    </div>
                <?php endif; ?>
            <?php endif; ?>
                </article>
            <?php endforeach; ?>

        <?php endif; ?>

    </section>
    <?php require __DIR__ . '/footer.php'; ?>
