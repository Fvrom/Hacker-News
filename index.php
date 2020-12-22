 <?php require __DIR__ . '/app/autoload.php'; ?>
 <?php require __DIR__ . '/header.php'; ?>

 <section class="home-page">
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

 </section>

 <?php require __DIR__ . '/footer.php'; ?>