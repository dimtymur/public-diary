<?php
session_start();
require_once $dimport["debug/error_show.php"]["path"];
require_once $dimport["auth/accept_auth.php"]["path"];
require_once $dimport["inc/gen_funcs.php"]["path"];
require_once $dimport["security/csrf_prev.php"]["path"];

if (!csrf_check($csrf_key))
  redirect($dimport["home/home_page.php"]["redirect"]."&error=csrf-error");

require_once $dimport["user/user_funcs.php"]["path"];

$user = $records_get("mpd_user", "user_id", $_SESSION["u_id"]);
if (empty($user))
  redirect($dimport["setts/setts_page.php"]["redirect"]."&error=invalid-user");
$user = $user[0];

if ($email_ver_get($user["user_id"]))
  redirect($dimport["setts/setts_page.php"]["redirect"]."&error=unverified-user");

if ($email_validate($_POST["email"]) && $_SESSION["u_email"] != $_POST["email"]) {
  $email_ver_send(
    $user,
    "localhost".$dimport["user/reset_email_verify.php"]["redirect"],
    "Email Change Verification",
    ["email" => $_POST["email"], "sess" => true]
  );
  $_SESSION["u_new_email"] = $_POST["email"];
  redirect($dimport["setts/setts_page.php"]["redirect"]."&success=verification-sent");
}

if ($uname_validate($_POST["username"]) && $_SESSION["u_name"] != $_POST["username"]) {
  $user_edits["username"]  = $_POST["username"];
  $_SESSION["u_name"]      = $_POST["username"];
}

if ($passwd_validate($_POST["password-new"], $_POST["password-conf"]) &&
    $passwd_validate($_POST["password-curr"])) {
  $passwd_hashed         = password_hash($_POST["password-new"], PASSWORD_DEFAULT);
  $user_edits["passwd"]  = $passwd_hashed;
  $_SESSION["u_pwd"]     = $passwd_hashed;
}

if (empty($user_edits))
  redirect($dimport["setts/setts_page.php"]["redirect"]."&error=invalid-info");

$records_edit(
  "mpd_user",
  "user_id",
  $user["user_id"],
  $user_edits
);
redirect($dimport["setts/setts_page.php"]["redirect"]."&success=edited-user");
