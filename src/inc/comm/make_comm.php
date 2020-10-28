<?php
session_start();
require_once $dimport["auth/accept_auth.php"]["path"];
require_once $dimport["inc/gen_funcs.php"]["path"];
require_once $dimport["security/csrf_prev.php"]["path"];
require_once $dimport["security/xss_prev.php"]["path"];
require_once $dimport["common/media_funcs.php"]["path"];

if (!csrf_check($csrf_key))
    redirect($dimport["home/home_page.phtml"]["redirect"]."&error=csrf-error");

if (empty($_POST["post-id"]))
    redirect($dimport["home/home_page.phtml"]["redirect"]."&error=invalid-post");

require_once $dimport["db/db_funcs.php"]["path"];

$post = $records_get("mpd_post", "post_id", $_POST["post-id"]);
if (empty($post))
    redirect($dimport["home/home_page.phtml"]["redirect"]."&error=invalid-post");
$post = $post[0];

$post_id_uri = "&post-id=".$post['post_id'];
if (!empty($last_comm_ts) && $within_time($last_comm_ts[0]["comm_ts"], $time))
    redirect($dimport["post/post_page.phtml"]["redirect"]."$post_id_uri&error=frequent-comm");

if (empty($_POST["comm"]))
    redirect($dimport["post/post_page.phtml"]["redirect"]."$post_id_uri&error=invalid-input");

$comm_text = xss_prev(trim($_POST["comm"]));
$comm_text = str_replace("\n", NEWLINER, $comm_text);

if (!(strlen($comm_text) < 8000))
    redirect($dimport["post/post_page.phtml"]["redirect"]."$post_id_uri&error=invalid-input");

$record_add(
    "mpd_comm",
    [
        "comm"     => $comm_text,
        "user_id"  => $_SESSION["u_id"],
        "post_id"  => $post["post_id"],
        "comm_dt"  => date("Y-m-d H:i:s")
    ]
);
redirect($dimport["post/post_page.phtml"]["redirect"]."$post_id_uri&success=comm-submitted");
