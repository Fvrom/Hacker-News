<?php require __DIR__ . '/app/autoload.php'; ?>
<?php require __DIR__ . '/header.php'; ?>

<?php if (isset($_SESSION['errors'])) {  ?>
    <p class="error-message"> <?php errorMessage();
                                unset($_SESSION['errors']); //delete error message after displayed
                            } ?> </p>



    <?php
    if (!isset($_SESSION['user'])) : ?>
        <p> You need to be logged in to submit posts! </p>

    <?php endif; ?>


    <?php if (isset($_SESSION['user'])) : ?>

        <section class="submit-section">

            <article class="submit-container">
                <h2 class="title-form"> Submit a post</h2>
                <form class="submit-form" action="/app/posts/posts.php" method="post">
                    <div class="log-in">
                        <label for="title"> Title </label>
                    </div>
                    <div class="submit">
                        <input type="text" name="title" id="title" required>
                    </div>
                    <div class="log-in">
                        <label for="description"> Description </label>
                    </div>
                    <div class="submit">
                        <input class="description-input" type="text" name="description" id="description" placeholder="Paragraf" required>
                    </div>
                    <div class="log-in">
                        <label for="url"> Url to the post </label>
                    </div>
                    <div class="submit">
                        <input type="url" name="url" id="url" placeholder="www.hackernews.com" required>
                    </div>

                    <div class="btn-wrapper">
                        <button class="btn-post-submit" type="submit" class="submit-button"> Create post </button>
                    </div>

                </form>


            </article>
        </section>

    <?php endif; ?>