 <?php require __DIR__ . '/app/autoload.php'; ?>
 <?php require __DIR__ . '/header.php'; ?>



 <section>

     <article class="home-page">


         <div class="successful-container">
             <?php if (isset($_SESSION['successful'])) {  ?>
                 <p class="successful-message"> <?php successfulMessage();
                                                unset($_SESSION['successful']); //delete error message after displayed
                                            } ?> </p>
         </div>
         <?php if (isset($_SESSION['errors'])) {  ?>
             <p class="error-message"> <?php errorMessage();
                                        unset($_SESSION['errors']); //delete error message after displayed
                                    } ?> </p>


             <?php if (isset($_SESSION['user'])) : ?>
                 <p> You are logged in,
                     <?php echo $_SESSION['user']['username']; ?> ! </p>

             <?php endif; ?>
     </article>



     <?php $allPost = getAllPosts($pdo, $allPosts);

        foreach ($allPost as $post) : ?>
         <?php $postId = $post['id'];  ?>

         <?php $countComments = countComments($pdo, $postId); ?>
         <?php $countLikes = countLikes($pdo, $postId); ?>

         <article class="home-page">

             <div class="posts-wrapper">
                 <div class="post-item-author">
                     <p> By: <?php echo $post['user_id']; ?> ,

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



                                 <input type="hidden" name="post-id" id="post-id" value="<?php echo $post['id'] ?>">
                                 <button type="submit"> Like </button>
                             </p>
                         </form>
                     </div>
                 </div>
             </div>


         </article>
     <?php endforeach; ?>


 </section>



 <?php require __DIR__ . '/footer.php'; ?>