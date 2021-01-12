<?php require __DIR__ . '/app/autoload.php'; ?>
<?php require __DIR__ . '/header.php'; ?>
<?php

if (isset($_GET['id'])) {
    $postId = $_GET['id'];
    $postIdComment = $postId;

    $userId = $_SESSION['user']['id'];
    $post = getPostbyId($pdo, $postId);

    $countComments = countComments($pdo, $postId);
    $countLikes = countLikes($pdo, $postId);

    $userComments = getPostsComments($pdo, $postId);
}

?>


<div class="successful-container">
    <?php if (isset($_SESSION['successful'])) {  ?>
        <p class="successful-message"> <?php successfulMessage();
                                        unset($_SESSION['successful']); //delete error message after displayed
                                    } ?> </p>
</div>


<article class="home-page">

    <div class="posts-wrapper">
        <div class="post-item-author">
            <p> By: <a href="profile.php?username=<?php echo $post['username']; ?> "> <?php echo $post['username']; ?> </a> ,

                <?php echo $post['post_date']; ?> </p>


        </div>
        <div class="post-item">
            <h3 class="post-title"> <?php echo $post['title']; ?> </h3>
        </div>
        <div class="post-item">
            <p class="post-description"> <?php echo $post['description']; ?> </p>
        </div>
        <div class="post-item-url">
            <p> ( <a href="<?php echo $post['post_url'] ?> "> <?php echo $post['post_url']; ?> </a> )
            <p>
        </div>


        <div class="info-wrapper">

            <div class="post-item-comment">
                <a href="comments.php?id=<?php echo $post['id']; ?> "> <?php echo $countComments; ?> Comments </a>

            </div>




            <div class="post-item-like">
                <form action="/app/posts/likes.php" method="post">
                    <p> <?php echo $countLikes; ?> Likes

                        <?php $isLikedByUser = isLikedByUser($pdo, $postId, $userId); ?>

                        <?php if (is_array($isLikedByUser)) : ?>
                            <input type="hidden" name="post-id" id="post-id" value="<?php echo $post['id'] ?>">
                            <button class="unlike-button" type="submit"> Unlike </button>
                        <?php else : ?>

                            <input type="hidden" name="post-id" id="post-id" value="<?php echo $post['id'] ?>">
                            <button class="like-button" type="submit"> Like </button>

                        <?php endif; ?>


                    </p>
                </form>
            </div>
        </div>
    </div>


</article>

<?php if (!is_array($userComments)) : ?>
    <div class="comments-wrapper">
        <div class="post-item">
            <p> No Comments yet </p>
        </div>
    </div>

<?php endif; ?>


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





<?php if (is_array($userComments)) : ?>
    <?php foreach ($userComments as $userComment) : ?>

        <article class="comments-page">

            <div class="comments-wrapper">
                <div class="post-item">
                    <p> By: <a href="profile.php?username=<?php echo $userComment['username']; ?> "> <?php echo $userComment['username']; ?></a>,
                        <?php echo $userComment['comment_date']; ?> </p>
                </div>
                <div class="post-item">
                    <p> <?php echo $userComment['comment']; ?> </p>
                </div>


            </div>
            </div>
            <div>
                <?php if ($userComment['user_id'] === $_SESSION['user']['id']) : ?>

                    <button> Edit Comment </button>
                    <div class="post-item">
                        <form action="/app/posts/update.php" method="post">
                            <!-- This is to be hidden. Gets visable when user clicks on Edit comment -->
                            <input type="text" name="comment" id="comment" placeholder=" <?php echo $userComment['comment']; ?>">

                            <input type="hidden" name="comment_id" id="comment_id" value="<?php echo $userComment['comment_id'] ?>">

                            <input type="hidden" name="post_id" id="post_id" value="<?php echo $post['id']; ?>">
                            <button type="submit"> Update comment </button>
                            <!-- end of hidden -->
                    </div>

                    </form>
                    <form action="/app/posts/delete.php" method="post">
                        <input type="hidden" name="user_id_delete_comment" id="user_id_delete_comment" value="<?php echo $userComment['user_id'] ?>">
                        <input type="hidden" name="comment_id" id="comment_id" value="<?php echo $userComment['comment_id'] ?>">
                        <input type="hidden" name="post_id" id="post_id" value="<?php echo $post['id']; ?>">


                        <button type="submit"> Delete comment </button>
                    </form>
                <?php endif; ?>
            </div>
        </article>
    <?php endforeach; ?>
<?php endif;
?>