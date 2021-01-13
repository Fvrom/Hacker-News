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
    <?php if (isset($_SESSION['successful'])) :  ?>
        <p class="successful-message"> <?php successfulMessage();  ?>
        <?php unset($_SESSION['successful']);
    endif; ?> </p>
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
            <a href="<?php echo $post['post_url'] ?> "> Get to article here </a>

        </div>

        <div class="info-wrapper">
            <div class="post-item-comment">
                <a href="comments.php?id=<?php echo $post['id']; ?> "> <?php echo $countComments; ?> Comments </a>
            </div>
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
        <div class="post-item">

            <div class="post-item">
                <input type="hidden" name="post_id" id="post_id" value="<?php echo $postId ?>">
            </div>
            <label for="comment"> Comment </label>

            <input type="text" name="comment" id="comment">
            <div class="btn-wrapper">
                <button class=" comment-btn" type="submit" class="submit-button"> Post comment </button>
            </div>
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

            <?php if ($userComment['user_id'] === $_SESSION['user']['id']) : ?>
                <!-- <button class="comment-btn"> Edit Comment </button> -->
                <!-- Want to implement this with javascript in the future -->
                <div class="comments-container">
                    <form class="comments-form" action="/app/posts/update.php" method="post">
                        <!-- This is to be hidden. Gets visable when user clicks on Edit comment -->
                        <input type="text" name="comment" id="comment" placeholder=" <?php echo $userComment['comment']; ?>">

                        <input type="hidden" name="comment_id" id="comment_id" value="<?php echo $userComment['comment_id'] ?>">

                        <input type="hidden" name="post_id" id="post_id" value="<?php echo $post['id']; ?>">
                        <div class="btn-wrapper">
                            <button class="comment-btn" type="submit"> Update comment </button>
                        </div>
                    </form>
                </div>

                <div class="comments-container">
                    <form action="/app/posts/delete.php" method="post">
                        <input type="hidden" name="user_id_delete_comment" id="user_id_delete_comment" value="<?php echo $userComment['user_id'] ?>">
                        <input type="hidden" name="comment_id" id="comment_id" value="<?php echo $userComment['comment_id'] ?>">
                        <input type="hidden" name="post_id" id="post_id" value="<?php echo $post['id']; ?>">

                        <button class="comment-btn" type="submit"> Delete comment </button>
                    </form>
                </div>

            <?php endif; ?>

        </article>
    <?php endforeach; ?>
<?php endif;
?>
