<?php
require_once __DIR__ . "/../../Template.php";

Template::header("New comment");
?>

<h1>New comment</h1>

<form action="<?= $this->home ?>/comments" method="post">
    <input type="text" name="product_name" placeholder="Product name"> <br>
    <input type="number" name="price" placeholder="Price"> <br>

    <?php if ($this->user->user_role === "admin") : ?>
        <input type="number" name="user_id" placeholder="User ID"> <br>
    <?php endif; ?>

    <input type="submit" value="Save" class="btn">
</form>

<?php Template::footer(); ?>