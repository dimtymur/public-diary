<?php
session_start();
require_once $dimport["auth/accept_unauth.php"]["path"];
require_once $dimport["security/csrf_prev.php"]["path"];

$title = "Login";
include_once $dimport["layouts/header.phtml"]["path"];
?>

<form class="main-wrap"
			id="auth-wrap"
			action="<?= $dimport['auth/login.php']['redirect'] ?>"
			method="POST">
	Username:
	<input name="username" class="main-inp" id="auth-inp" pattern="[a-zA-Z0-9_-]{3,20}" required>
	Password:
	<input type="password" name="password" class="main-inp" id="auth-inp" pattern=".{7,}" required>
	<?= $csrf_form_get ?>
	<button type="submit" name="submit" class="main-btn"> Login </button>
	<a href="<?= $dimport['auth/pwd_reset_page.php']['redirect'] ?>">
		<p id="pass-forgot-text"> I Forgot My Password! </p>
	</a>
</form>

<?php
include_once $dimport["layouts/footer.phtml"]["path"];
