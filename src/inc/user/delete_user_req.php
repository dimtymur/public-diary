<?php
session_start();
require_once $dimport["auth/accept_auth.php"]["path"];
require_once $dimport["inc/gen_funcs.php"]["path"];
require_once $dimport["security/csrf_prev.php"]["path"];

if (!csrf_check($csrf_key))
    redirect($dimport["home/home_page.php"]["redirect"]."&error=csrf-error");

require_once $dimport["user/user_funcs.php"]["path"];

if (!$passwd_validate($_POST["password"], $_POST["password-conf"]) &&
    !$passwd_validate($_POST["password"], $user["passwd"], false))
    redirect($dimport["setts/del_page.php"]["redirect"]."&error=invalid-password");

$user = $records_get("mpd_user", "user_id", $_SESSION["u_id"]);
if (empty($user))
    redirect($dimport["setts/del_page.php"]["redirect"]."&error=invalid-user");
$user = $user[0];

if ($email_ver_get($user["user_id"]))
    redirect($dimport["setts/del_page.php"]["redirect"]."&error=unverified-user");

$email_ver_send(
    $user,
    "localhost".$dimport["user/delete_user_verify.php"]["redirect"],
    "Account Delete Verification",
    ["sess" => true]
);
redirect($dimport["setts/del_page.php"]["redirect"]."&success=verification-sent");
