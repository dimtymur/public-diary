<?php
session_start();
require_once $dimport["auth/accept_auth.php"]["path"];
require_once $dimport["security/csrf_prev.php"]["path"];

$title = "Settings";
include_once $dimport["layouts/header.phtml"]["path"];
?>

<div class="mid-cont">
	<div class="main-wrap">
		<form action="<?= $dimport["user/edit_user.php"]["redirect"] ?>"
	        method="POST">
	    <h1 class="setts-title"> Information </h1>
	    <div class="main-wrap" id="setts-sec">
	      Username:
	      <input name="username" class="main-inp" id="setts-inp" pattern="[a-zA-Z0-9_-]{3,20}" value="<?= $_SESSION["u_name"] ?>">
	      Email:
	      <input name="email" class="main-inp" id="setts-inp" type="email" value="<?= $_SESSION["u_email"] ?>">
	    </div>
	    <h1 class="setts-title"> Password </h1>
	    <div class="main-wrap" id="setts-sec">
	      New Password:
	      <input name="password-new" class="main-inp" id="setts-inp" type="password" pattern=".{7,}">
	      New Password (Confirm):
	      <input name="password-conf" class="main-inp" id="setts-inp" type="password" pattern=".{7,}">
	      Current Password:
	  		<input name="password-curr" class="main-inp" id="setts-inp" type="password" pattern=".{7,}">
	    </div>
	    <?= $csrf_form_get ?>
	    <button type="submit" name="submit" class="main-btn" id="setts-btn"> Update </button>
		</form>
		<br>
		<a href="<?= $dimport["setts/del_page.php"]["redirect"] ?>">
			<button class="main-btn" id="setts-btn"> Delete Account </button>
		</a>
	</div>
</div>

<?php
include_once $dimport["layouts/footer.phtml"]["path"];
