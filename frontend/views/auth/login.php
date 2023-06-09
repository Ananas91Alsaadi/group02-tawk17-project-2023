<?php
require_once __DIR__ . "/../../Template.php";
$hide="password";
Template::header("Login", $this->model["error"]);
?>

<h1>Login</h1>

<form action="<?= $this->home ?>/auth/login" method="post">
    <input type="text" name="user_name" placeholder="Username"> <br>
    <div class="pass">
    <input type="password" name="password" placeholder="Password" id="password"> <div onclick="showHide()">Show/Hide Password </div> 
    </div> <br> 
    <input type="submit" value="Log in" class="btn">
</form>

<p>
    Not registered? 
    <a href="<?= $this->home ?>/auth/register">Register user</a>
</p>

<?php Template::footer(); ?>