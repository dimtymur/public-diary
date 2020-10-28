<?php
session_start();
require_once $dimport["auth/accept_unauth.php"]["path"];
require_once $dimport["inc/gen_funcs.php"]["path"];
require_once $dimport["user/user_funcs.php"]["path"];

if (!$email_ver = $email_ver_get($_SESSION["token_u_id"]))
    redirect($dimport["home/home_page.phtml"]["redirect"]."&error=invalid-verify");

$user = $records_get("mpd_user", "user_id", $email_ver["user_id"]);
if (empty($user))
    redirect($dimport["auth/login_page.phtml"]["redirect"]."&error=invalid-user");
$user = $user[0];

if (!$email_ver_validate($email_ver)) {
    $email_ver_send(
        $user,
        "localhost".$dimport["auth/signin_verify.php"]["redirect"],
        "Account Verification"
    );
    redirect($dimport["auth/login_page.phtml"]["redirect"]."&error=verification-resent");
}

session_unset();
session_destroy();
$records_delete("mpd_email_ver", "user_id", $user["user_id"]);
redirect($dimport["auth/login_page.phtml"]["redirect"]."&success=verification-done");
