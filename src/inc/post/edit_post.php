<?php
session_start();
require_once $dimport["auth/accept_auth.php"]["path"];
require_once $dimport["inc/gen_funcs.php"]["path"];
require_once $dimport["security/csrf_prev.php"]["path"];
require_once $dimport["common/media_funcs.php"]["path"];

if (!csrf_check($csrf_key))
    redirect($dimport["home/home_page.phtml"]["redirect"]."&error=csrf-error");

if (!empty($last_post_ts) && $within_time($last_post_ts[0]["post_ts"], $time))
    redirect($dimport["post/make_post_page.phtml"]["redirect"]."&error=frequent-post");

if (empty($_GET["post-id"]))
    redirect($dimport["home/home_page.phtml"]["redirect"]."&error=invalid-post");

require_once $dimport["db/db_funcs.php"]["path"];

$post = $records_get("mpd_post", "post_id", $_GET["post-id"]);
if (empty($post))
    redirect($dimport["home/home_page.phtml"]["redirect"]."&error=invalid-post");
$post = $post[0];

if ($post["user_id"] != $_SESSION["u_id"])
    redirect($dimport["home/home_page.phtml"]["redirect"]."&error=invalid-post");

require_once $dimport["security/xss_prev.php"]["path"];

$title  = xss_prev(trim($_POST["title"]));
$title  = str_replace("\n", "~_", $title);
$text   = xss_prev(trim($_POST["text"]));
$text   = str_replace("\n", "~_", $text);

$post_id_uri = "&post-id=".$post["post_id"];
if (!(strlen($title) < 100) || !(strlen($text) < 10000))
    redirect($dimport["post/make_post_page.phtml"]["redirect"]."$post_id_uri&error=invalid-input");

$records_edit(
    "mpd_post",
    "post_id",
    $post["post_id"],
    ["title" => $title, "text" => $text]
);
redirect($dimport["post/post_page.phtml"]["redirect"]."$post_id_uri&success=post-edited");
