<?php
require_once __DIR__ . "/../../Template.php";

Template::header("Edit " . $this->model->comment_id);
?>

<h1>Edit <?= $this->model->comment_id ?></h1>

<form action="<?= $this->home ?>/comments/<?= $this->model->comment_id ?>/edit" method="post">
    <input type="text" name="product_name" value="<?= $this->model->product_name ?>" placeholder="Product name"> <br>
    <input type="number" name="price" value="<?= $this->model->price ?>" placeholder="Price"> <br>

    <input type="number" name="user_id" value="<?= $this->model->user_id ?>" placeholder="User ID"> <br>

    <input type="submit" value="Save" class="btn">
</form>

<form action="<?= $this->home ?>/comments/<?= $this->model->comment_id ?>/delete" method="post">
    <input type="submit" value="Delete" class="btn delete-btn">
</form>

<?php Template::footer(); ?>


<!--

<h1>comments</h1>

<a href="<?= $this->home ?>/comments/new">Create new</a>
<?= $this->model ?> 
<div class="item-grid">

    <?php foreach ($this->model as $comment) : ?>

        <article class="item">
            <div>
                <b><?= $comment->product_name ?></b> <br>
                <span>Price: <?= $comment->price ?></span> <br>
                <span>commentd: <?= $comment->comment_time ?></span> <br>
            </div>


            <?php if ($this->user->user_role === "admin") : ?>

                <p>
                    <b>User ID: </b>
                    <?= $comment->user_id ?>
                </p>
            <a href="<?= $this->home ?>/comments/<?= $comment->comment_id ?>/edit">Edit</a>

            <?php endif; ?>

            <a href="<?= $this->home ?>/comments/<?= $comment->comment_id ?>">Show</a>
        </article>

    <?php endforeach; ?>

</div>

-->