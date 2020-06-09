<?php
session_start();
require_once $dimport["auth/accept_unauth.php"]["path"];
require_once $dimport["inc/gen_funcs.php"]["path"];
require_once $dimport["security/csrf_prev.php"]["path"];
require_once $dimport["debug/error_show.php"]["path"];

if (!csrf_check($csrf_key))
  redirect($dimport["auth/signin_page.php"]["redirect"]."&error=csrf-error");

if (!isset($_POST["submit"]))
  redirect($dimport["auth/signin_page.php"]["redirect"]."&error=submit-error");

require_once $dimport["user/user_funcs.php"]["path"];

if (!$uname_validate($_POST["username"]))
  redirect($dimport["auth/signin_page.php"]["redirect"]."&error=invalid-username");
$username = $_POST["username"];

if (!$email_validate($_POST["email"]))
  redirect($dimport["auth/signin_page.php"]["redirect"]."&error=invalid-email");
$email = $_POST["email"];

if (!$passwd_validate($_POST["password"], $_POST["password-conf"]))
  redirect($dimport["auth/signin_page.php"]["redirect"]."&error=invalid-passwd");
$passwd_hashed = password_hash($_POST["password"], PASSWORD_DEFAULT);

$record_add(
  "mpd_user",
  [
    "username"  => $username,
    "email"     => $email,
    "passwd"    => $passwd_hashed,
    "user_dt"   => date("Y-m-d H:i:s")
  ]
);

$user = $records_get("mpd_user", "username", $username);
if (empty($user))
  redirect($dimport["auth/signin_page.php"]["redirect"]."&error=invalid-signin");
$user = $user[0];

$_SESSION["token_u_id"] = $user["user_id"];
$email_ver_send(
  $user,
  "localhost".$dimport["auth/signin_verify.php"]["redirect"],
  "Account Verification"
);
redirect($dimport["auth/login_page.php"]["redirect"]."&success=verification-sent");
