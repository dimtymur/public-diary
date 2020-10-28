<?php
session_start();
require_once $dimport["auth/accept_unauth.php"]["path"];
require_once $dimport["inc/gen_funcs.php"]["path"];
require_once $dimport["security/csrf_prev.php"]["path"];

if (!csrf_check($csrf_key))
    redirect($dimport["home/home_page.phtml"]["redirect"]."&error=csrf-error");

require_once $dimport["user/user_funcs.php"]["path"];

if (!$email_validate($_POST["email"], false))
    redirect($dimport["auth/pwd_reset_page.phtml"]["redirect"]."&error=invalid-email");
$email = $_POST["email"];

$user = $records_get("mpd_user", "email", $email)[0];
if ($email_ver_get($user["user_id"]))
    redirect($dimport["auth/pwd_reset_page.phtml"]["redirect"]."&error=unverified-user");

if (!$passwd_validate($_POST["password-new"], $_POST["password-conf"]))
    redirect($dimport["auth/pwd_reset_page.phtml"]["redirect"]."&error=invalid-password");
$_SESSION["u_new_pwd"] = $_POST["password-new"];

$_SESSION["token_u_id"] = $user["user_id"];
$email_ver_send(
    $user,
    "localhost".$dimport["user/reset_pwd_verify.php"]["redirect"],
    "Password Reset Verification",
    ["sess" => true]
);
redirect($dimport["auth/pwd_reset_page.phtml"]["redirect"]."&success=verification-sent");
