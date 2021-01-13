 <?php require __DIR__ . '/app/autoload.php'; ?>
 <?php require __DIR__ . '/header.php'; ?>

 <?php $userId = $_SESSION['user']['id']; ?>

 <section>
     <article class="home-page">
         <div class="successful-container">
             <?php if (isset($_SESSION['successful'])) :  ?>
                 <p class="successful-message"> <?php successfulMessage(); ?>
                 <?php unset($_SESSION['successful']); //delete error message after displayed
                endif; ?> </p>
         </div>
         <?php if (isset($_SESSION['errors'])) :  ?>
             <p class="error-message"> <?php errorMessage(); ?>
             <?php unset($_SESSION['errors']); //delete error message after displayed
            endif; ?> </p>



     </article>

     <?php $allPost = getAllPosts($pdo, $allPosts);

        foreach ($allPost as $post) : ?>
         <?php $postId = $post['id'];  ?>

         <?php $countComments = countComments($pdo, $postId); ?>
         <?php $countLikes = countLikes($pdo, $postId); ?>

         <article class="home-page">

             <div class="posts-wrapper">
                 <div class="post-item-author">
                     <p> By: <a href="profile.php?username=<?php echo $post['username']; ?> "> <?php echo $post['username']; ?></a> ,
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
     <?php endforeach; ?>

 </section>

 <?php require __DIR__ . '/footer.php'; ?>
