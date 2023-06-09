<?php

class Template
{
    public static function header($title, $error = false)
    {
        $home_path = getHomePath();
        $user = getUser();
?>
        <!DOCTYPE html>
        <html lang="en">

        <head>
            <meta charset="UTF-8">
            <meta http-equiv="X-UA-Compatible" content="IE=edge">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title><?= $title ?> - Multitier Shop</title>

            <link rel="stylesheet" href="<?= $home_path ?>/assets/css/style.css">

            <script src="<?= $home_path ?>/assets/js/script.js"></script>
        </head>

        <body>
            <header >
            <img class="logo" src="<?= $home_path ?>/assets/img/logo.png">

                <h1><?= $title; ?></h1>
            </header>

            <nav>
                <a href="<?= $home_path ?>">Start</a>
                <a href="<?= $home_path ?>/movies">Movies</a>

                <?php if ($user) : ?>
                    <a href="<?= $home_path ?>/auth/profile"> <?= $user->user_name ?> <?php if ($user->user_role=="admin") { echo "/admin";} ?> </a>
                  <!--  <a href="<?= $home_path ?>/comments">comments</a>-->
                <?php else : ?>
                    <a href="<?= $home_path ?>/auth/login">Log in</a>
                <?php endif; ?>
            </nav>

            <main>

                <?php if ($error) : ?>
                    <div class="error">
                        <p><?= $error ?></p>
                    </div>
                <?php endif; ?>

            <?php }



        public static function footer()
        {
            ?>
            </main>
            <footer>
                Copyright 2023
            </footer>
        </body>

        </html>
<?php }
    }
