<?php require __DIR__ . '/app/autoload.php'; ?>
<?php require __DIR__ . '/header.php'; ?>
<?php

if (isset($_GET['id'])) {
    $postId = $_GET['id'];
    $postIdComment = $postId;

    $post = getPostbyId($pdo, $postId);

    $countComments = countComments($pdo, $postId);
    $countLikes = countLikes($pdo, $postId);

    $userComments = getPostsComments($pdo, $postId);
}

?>




<article class="home-page">
    <div class="successful-container">
        <?php if (isset($_SESSION['successful'])) {  ?>
            <p class="successful-message"> <?php successfulMessage();
                                            unset($_SESSION['successful']); //delete error message after displayed
                                        } ?> </p>
    </div>


    <div class="posts-wrapper">
        <div class="post-item">
            <h3 class="post-title"> <?php echo $post['title']; ?> </h3>
        </div>
        <div class="post-item">
            <p class="post-description"> <?php echo $post['description']; ?> </p>
        </div>
        <div class="post-item">
            <a href="<?php echo $post['post_url'] ?> "> <?php echo $post['post_url']; ?> </a>
        </div>
        <div class="post-item-author">
            <p> Posted by: <?php echo $post['user_id']; ?> </p>

        </div>
        <div class="post-item-date">
            <p> <?php echo $post['post_date']; ?> </p>
        </div>
        <div class="post-item-date">
            <p> Comments <?php echo $countComments; ?> </p>

        </div>
        <div>

            <p> Likes
                <?php echo $countLikes; ?> </p>
            <form action="/app/posts/likes.php" method="post">

                <input type="hidden" name="post-id" id="post-id" value="<?php echo $post['id'] ?>">
                <button type="submit"> Like </button>
            </form>
        </div>

    </div>
</article>


<?php if (isset($_SESSION['user'])) : ?>

    <form action="/app/posts/commentStore.php" method="post">


        <div class="posts-wrapper">
            <input type="hidden" name="post_id" id="post_id" value="<?php echo $postId ?>">
            <label for="comment"> Comment </label>

            <input type="text" name="comment" id="comment">

            <button type="submit" class="submit-button"> Post comment </button>

        </div>

    </form>

<?php endif; ?>

<article class="home-page">


    <?php if (isset($_SESSION['errors'])) {  ?>
        <p class="error-message"> <?php errorMessage();
                                    unset($_SESSION['errors']); //delete error message after displayed
                                } ?> </p>



        <?php if (is_array($userComments)) : ?>
            <?php foreach ($userComments as $userComment) : ?>
                <div class="posts-wrapper">
                    <div class="post-item">
                        <p> Commented by: <?php echo $userComment['username']; ?> </p>
                        <p> <?php echo $userComment['comment']; ?> </p>
                        <p> <?php echo $userComment['comment_date']; ?> </p>

                    </div>
                </div>
                <div>
                    <?php if ($userComment['user_id'] === $_SESSION['user']['id']) : ?>

                        <button> Edit Comment </button>

                        <form action="/app/posts/update.php" method="post">
                            <!-- This is to be hidden. Gets visable when user clicks on Edit comment -->
                            <input type="text" name="comment" id="comment" placeholder=" <?php echo $userComment['comment']; ?>">

                            <input type="hidden" name="comment_id" id="comment_id" value="<?php echo $userComment['comment_id'] ?>">

                            <input type="hidden" name="post_id" id="post_id" value="<?php echo $post['id']; ?>">
                            <button type="submit"> Update comment </button>
                            <!-- end of hidden -->

                        </form>
                        <form action="/app/posts/delete.php" method="post">
                            <input type="hidden" name="user_id_delete_comment" id="user_id_delete_comment" value="<?php echo $userComment['user_id'] ?>">
                            <input type="hidden" name="comment_id" id="comment_id" value="<?php echo $userComment['comment_id'] ?>">
                            <input type="hidden" name="post_id" id="post_id" value="<?php echo $post['id']; ?>">


                            <button type="submit"> Delete comment </button>
                        </form>
                    <?php endif; ?>
                </div>
            <?php endforeach; ?>
        <?php endif;
        ?>