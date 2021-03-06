<?php
session_start();
require_once $dimport["auth/accept_auth.php"]["path"];
require_once $dimport["app/main_funcs.php"]["path"];
require_once $dimport["security/csrf_prevent.php"]["path"];

if (!csrf_check($csrf_key))
    redirect($dimport["home/home_page.phtml"]["redirect"]."&error=csrf-error");

if (empty($_POST["post-id"]))
    redirect($dimport["home/home_page.phtml"]["redirect"]."&error=invalid-post");

require_once $dimport["db/db_funcs.php"]["path"];

$post = $records_get("post", "post_id", $_POST["post-id"]);
if (empty($post))
    redirect($dimport["home/home_page.phtml"]["redirect"]."&error=invalid-post");
$post = $post[0];

require_once $dimport["media/media_funcs.php"]["path"];

$post_id_uri = "&post-id=".$post['post_id'];
if ($media_within_time("comment", "comment_ts", $_SESSION["u_id"], $timeout))
    redirect($dimport["post/post_page.phtml"]["redirect"]."$post_id_uri&error=frequent-comment");

if (empty($_POST["text"]))
    redirect($dimport["post/post_page.phtml"]["redirect"]."$post_id_uri&error=invalid-input");

require_once $dimport["security/xss_prevent.php"]["path"];

$text = str_replace("\n", NEWLINER, xss_prevent(trim($_POST["text"])));

if (!(strlen($text) < 8000))
    redirect($dimport["post/post_page.phtml"]["redirect"]."$post_id_uri&error=invalid-input");

$record_add(
    "comment",
    [
        "text"        => $text,
        "user_id"     => $_SESSION["u_id"],
        "post_id"     => $post["post_id"],
        "comment_dt"  => date("Y-m-d H:i:s")
    ]
);
redirect($dimport["post/post_page.phtml"]["redirect"]."$post_id_uri&success=comment-submitted");
