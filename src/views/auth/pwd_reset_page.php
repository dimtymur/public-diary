<?php
session_start();
require_once $dimport["security/csrf_prev.php"]["path"];
require_once $dimport["user/user_funcs.php"]["path"];

if ($email_ver_get($user["user_id"]))
    redirect($dimport["auth/pwd_reset_page.php"]["redirect"]."&error=unverified-user");

$title = "Reset Password";
include_once $dimport["layouts/header.phtml"]["path"]; ?>

<div class="mid-cont">
    <div class="main-wrap">
        <form action="<?= $dimport["user/reset_pwd_req.php"]["redirect"] ?>"
            method="POST">
            <h1 class="setts-title"> Information </h1>
            <p class="setts-desc">
                Enter your account's email for the verification code to be sent to.
            </p>
            <div class="main-wrap" id="setts-sec">
                Email:
                <input name="email" class="main-inp" id="setts-inp" type="email" value="<?= $_SESSION["u_email"] ?>" required>
            </div>
            <h1 class="setts-title"> Password </h1>
            <p class="setts-desc">
                Enter your new password.
            </p>
            <div class="main-wrap" id="setts-sec">
                New Password:
                <input name="password-new" class="main-inp" id="setts-inp" type="password" required>
                New Password (Confirm):
                <input name="password-conf" class="main-inp" id="setts-inp" type="password" required>
            </div>
            <?= $csrf_form_get ?>
            <button type="submit" name="submit" class="main-btn" id="setts-btn"> Update </button>
        </form>
    </div>
</div>

<?php include_once $dimport["layouts/footer.phtml"]["path"];
