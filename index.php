 <?php require __DIR__ . '/app/autoload.php'; ?>
 <?php require __DIR__ . '/header.php'; ?>



 <section>

     <artcile class="home-page">
         <p>Home page</p>

         <div class="successful-container">
             <?php if (isset($_SESSION['successful'])) {  ?>
                 <p class="successful-message"> <?php successfulMessage();
                                                unset($_SESSION['successful']); //delete error message after displayed
                                            } ?> </p>
         </div>

         <?php if (isset($_SESSION['user'])) : ?>
             <p> You are logged in,
                 <?php echo $_SESSION['user']['first_name']; ?> ! </p>

         <?php endif; ?>
     </artcile>



     <?php $allPost = getAllPosts($pdo, $allPosts);

        foreach ($allPost as $post) : ?>
         <?php $postId = $post['id'];  ?>

         <?php $countComments = countComments($pdo, $postId); ?>
         <?php $countLikes = countLikes($pdo, $postId); ?>

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
     <?php endforeach; ?>


 </section>



 <?php require __DIR__ . '/footer.php'; ?>