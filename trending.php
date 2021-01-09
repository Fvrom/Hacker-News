<?php require __DIR__ . '/app/autoload.php'; ?>
<?php require __DIR__ . '/header.php'; ?>


<article>

    <?php $topLikes = topLikes($pdo);
    print_r($topLikes); ?>

    <?php // foreach ($topLikest as $toplike) : 
    ?>

    <?php $postId = $toplike['post_id'];  ?>

    <?php $countComments = countComments($pdo, $postId); ?>
    <?php $countLikes = countLikes($pdo, $postId); ?>
    <?php $post = getPostbyId($pdo, $postId); ?>



    <article class="home-page">

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
                <a href="comments.php?id=<?php echo $post['id']; ?> "> Comments </a>
                <?php echo $countComments; ?>
            </div>

    </article>
    <?php// endforeach; ?>