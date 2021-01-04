<?php require __DIR__ . '/app/autoload.php'; ?>
<?php require __DIR__ . '/header.php'; ?>
<?php

if (isset($_GET['id'])) {
    $postId = $_GET['id'];

    $post = getPostbyId($pdo, $postId);

    $countComments = countComments($pdo, $postId);

    $userComments = getPostsComments($pdo, $postId);

    // $userComments = getPostsComments($pdo, $postId);
}

?>


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
            <p> Comments <?php echo $countComments; ?> </p>

        </div>
</article>

</div>
<article class="home-page">
    <div class="posts-wrapper">
        <div class="post-item">
            <?php foreach ($userComments as $userComment) : ?>

                <p> Commented by: <?php echo $userComment['username']; ?> </p>
                <p> <?php echo $userComment['comment']; ?> </p>
                <p> <?php echo $userComment['comment_date']; ?> </p>
        </div>
    </div>
<?php endforeach; ?>




<article>
    <?php //foreach ($userComments as $userComment) : 
    ?>

</article>
<?php //endforeach; 
?>