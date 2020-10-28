<?php
session_start();
require_once $dimport["auth/accept_auth.php"]["path"];
require_once $dimport["inc/gen_funcs.php"]["path"];
require_once $dimport["user/user_funcs.php"]["path"];

$user = $records_get("mpd_user", "user_id", $_SESSION["u_id"]);
if (empty($user))
    redirect($dimport["setts/setts_page.phtml"]["redirect"]."&error=invalid-user");
$user = $user[0];

if ($email_ver_get($user["user_id"]))
    redirect($dimport["setts/setts_page.phtml"]["redirect"]."&error=unverified-user");

if (empty($_SESSION["u_new_email"]))
    redirect($dimport["setts/setts_page.phtml"]["redirect"]."&error=invalid-verify");
$new_email = $_SESSION["u_new_email"];

if (!$email_validate($new_email))
    redirect($dimport["setts/setts_page.phtml"]["redirect"]."&error=invalid-email");

if (!$email_ver_validate($_SESSION)) {
    $email_ver_send(
        $user,
        "localhost".$dimport["user/reset_email_verify.php"]["redirect"],
        "Email Change Verification",
        ["email" => $new_email, "sess" => true]
    );
    redirect($dimport["setts/setts_page.phtml"]["redirect"]."&error=email-resent");
}

$records_edit(
    "mpd_user",
    "user_id",
    $user["user_id"],
    ["email" => $new_email]
);
$_SESSION["u_email"] = $new_email;
redirect($dimport["setts/setts_page.phtml"]["redirect"]."&success=verification-done");
