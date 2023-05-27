<?php
require_once __DIR__ . "/../../Template.php";

Template::header("Profile");
?>

<p>
    Logged in as <b><?= $this->user->user_name ?></b>
</p>

<?php if ($this->user->user_role === "admin") : ?>
    <p>(admin user)</p>
<?php endif; ?>
<hr>

<form action="<?= $this->home ?>/auth/change" method="post">
Change password:
<input type="password" name="password">
<input type="submit" value="Change">
</form>

<hr>

<form action="<?= $this->home ?>/auth/delete" method="post">
<input type="submit" value="Delete Account and all comments" class="btn delete-btn">
</form>




<hr>


<h2>Log out</h2>
<form action="<?= $this->home ?>/auth/logout" method="post">
    <input type="submit" value="Log out" class="btn delete-btn">
</form>

<?php Template::footer(); ?>