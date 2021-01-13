<?php require __DIR__ . '/app/autoload.php'; ?>
<?php require __DIR__ . '/header.php'; ?>


<?php $userId = $_SESSION['user']['id']; ?>
<?php $topLikes = topLikes($pdo); ?>
<?php foreach ($topLikes as $topLike) : ?>
    <?php $postId = $topLike['id'];  ?>

    <?php $countComments = countComments($pdo, $postId); ?>
    <?php $countLikes = countLikes($pdo, $postId); ?>

    <article class="home-page">
        <div class="posts-wrapper">
            <div class="post-item-author">
                <p> By: <a href="profile.php?username=<?php echo $topLike['username']; ?> "> <?php echo $topLike['username']; ?></a> ,
                    <?php echo $topLike['post_date']; ?> </p>

            </div>
            <div class="post-item">
                <h3 class="post-title"> <?php echo $topLike['title']; ?> </h3>
            </div>
            <div class="post-item">
                <p class="post-description"> <?php echo $topLike['description']; ?> </p>
            </div>
            <div class="post-item-url">
                <a href="<?php echo $topLike['post_url'] ?> "> Get to article here </a>

            </div>


            <div class="info-wrapper">

                <div class="post-item-comment">
                    <a href="comments.php?id=<?php echo $topLike['id']; ?> "> <?php echo $countComments; ?> Comments </a>

                </div>

                <div class="post-item-like">
                    <form action="/app/posts/likes.php" method="post">
                        <p> <?php echo $countLikes; ?> Likes

                            <?php $isLikedByUser = isLikedByUser($pdo, $postId, $userId); ?>

                            <?php if (is_array($isLikedByUser)) : ?>
                                <input type="hidden" name="post-id" id="post-id" value="<?php echo $topLike['id'] ?>">
                                <button class="unlike-button" type="submit"> Unlike </button>
                            <?php else : ?>
                                <input type="hidden" name="post-id" id="post-id" value="<?php echo $topLike['id'] ?>">
                                <button class="like-button" type="submit"> Like </button>

                            <?php endif; ?>
                        </p>
                    </form>
                </div>
            </div>
        </div>


    </article>
<?php endforeach; ?>
