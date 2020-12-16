<?php require __DIR__ . '/app/autoload.php'; ?>
<?php require __DIR__ . '/header.php'; ?>

<section>
    <p>Home page</p>

    <?php if (isset($_SESSION['user'])) : ?>
        <p> You are logged in, <?= $_SESSION['user']['username']; ?> ! </p>

    <?php endif; ?>

</section>

<?php require __DIR__ . '/footer.php'; ?>