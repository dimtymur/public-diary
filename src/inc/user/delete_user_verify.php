<?php
session_start();
require_once $dimport["auth/accept_auth.php"]["path"];
require_once $dimport["user/user_funcs.php"]["path"];
require_once $dimport["inc/gen_funcs.php"]["path"];

if ($email_ver_get($_SESSION["u_id"]))
    redirect($dimport["setts/del_page.phtml"]["redirect"]."&error=invalid-verify");

$user = $records_get("mpd_user", "user_id", $_SESSION["u_id"]);
if (empty($user))
    redirect($dimport["setts/del_page.phtml"]["redirect"]."&error=invalid-user");
$user = $user[0];

if (!$email_ver_validate($_SESSION)) {
    $email_ver_send(
        $user,
        "localhost".$dimport["user/delete_user_verify.php"]["redirect"],
        "Account Delete Verification",
        ["sess" => true]
    );
    redirect($dimport["setts/del_page.phtml"]["redirect"]."&error=email-resent");
}

$records_delete("mpd_user", "user_id", $user["user_id"]);
require_once $dimport["auth/logout.php"]["path"];
