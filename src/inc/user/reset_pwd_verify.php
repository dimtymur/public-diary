<?php
session_start();
require_once $dimport["auth/accept_unauth.php"]["path"];
require_once $dimport["inc/gen_funcs.php"]["path"];
require_once $dimport["user/user_funcs.php"]["path"];

if ($email_ver_get($_SESSION["token_u_id"]))
  redirect($dimport["auth/pwd_reset_page.php"]["redirect"]."&error=unverified-user");

if (empty($_SESSION["token_u_id"]))
  redirect($dimport["auth/pwd_reset_page.php"]["redirect"]."&error=invalid-user");

$user = $records_get("mpd_user", "user_id", $_SESSION["token_u_id"]);
if (empty($user))
  redirect($dimport["auth/pwd_reset_page.php"]["redirect"]."&error=invalid-user");
$user = $user[0];

if (!$passwd_validate($_SESSION["u_new_pwd"]))
  redirect($dimport["auth/pwd_reset_page.php"]["redirect"]."&error=invalid-password");
$passwd_hashed = password_hash($_SESSION["u_new_pwd"], PASSWORD_DEFAULT);

if (!$email_ver_validate($_SESSION)) {
  $email_ver_send(
    $user,
    "localhost".$dimport["user/reset_pwd_verify.php"]["redirect"],
    "Password Reset Verification",
    ["sess" => true]
  );
  redirect($dimport["auth/pwd_reset_page.php"]["redirect"]."&error=verification-resent");
}

$records_edit(
  "mpd_user",
  "user_id",
  $user["user_id"],
  ["passwd" => $passwd_hashed]
);

session_unset();
session_destroy();
redirect($dimport["auth/login_page.php"]["redirect"]."&success=verification-done");
