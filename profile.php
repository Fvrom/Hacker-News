<?php require __DIR__ . '/app/autoload.php'; ?>
<?php require __DIR__ . '/header.php'; ?>

<?php
if (isset($_GET['username'])) : ?>

    <section class="home-page">

        <h1><?php echo $_GET['username']; ?> </h1>

        <!-- TO DO: 
        Get user from database. 
        Display 
        - profile picture
         - bio
         - posts made by the user
-->
    <?php endif; ?>



    </section>


    <?php require __DIR__ . '/footer.php'; ?>