<?php
session_start();
require_once $dimport["auth/accept_unauth.php"]["path"];
require_once $dimport["security/csrf_prev.php"]["path"];

$title = "Signin";
include_once $dimport["layouts/header.phtml"]["path"]; ?>

<form class="main-wrap"
			id="auth-wrap"
			action="<?= $dimport['auth/signin_req.php']['redirect'] ?>"
			method="POST">
	Username:
	<input name="username" class="main-inp" id="auth-inp" pattern="[a-zA-Z0-9_-]{3,20}" required>
	Email:
	<input type="email" name="email" class="main-inp" id="auth-inp" required>
	Password:
	<input type="password" name="password" class="main-inp" id="auth-inp" pattern=".{7,}" required>
	Password (Repeat):
	<input type="password" name="password-conf" class="main-inp" id="auth-inp" pattern=".{7,}" required>
	<?= $csrf_form_get ?>
	<button type="submit" name="submit" class="main-btn"> Signin </button>
</form>

<?php include_once $dimport["layouts/footer.phtml"]["path"];
