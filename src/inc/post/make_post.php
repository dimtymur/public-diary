<?php
session_start();
require_once $dimport["auth/accept_auth.php"]["path"];
require_once $dimport["inc/gen_funcs.php"]["path"];
require_once $dimport["security/csrf_prev.php"]["path"];
require_once $dimport["security/xss_prev.php"]["path"];

if (!csrf_check($csrf_key))
  redirect($dimport["post/make_post_page.php"]["redirect"]."&error=csrf-error");

if (empty($_POST["title"]) || empty($_POST["text"]))
  redirect($dimport["post/make_post_page.php"]["redirect"]."&error=invalid-input");

const NEWLINER = "~_";
$title  = xss_prev(trim($_POST["title"]));
$title  = str_replace("\n", NEWLINER, $title);
$text   = xss_prev(trim($_POST["text"]));
$text   = str_replace("\n", NEWLINER, $text);

if (!(strlen($title) < 100) || !(strlen($text) < 10000))
  redirect($dimport["post/make_post_page.php"]["redirect"]."&error=invalid-input");

require_once $dimport["db/db_funcs.php"]["path"];

$record_add(
  "mpd_post",
  [
    "title"    => $title,
    "text"     => $text,
    "user_id"  => $_SESSION["u_id"],
    "post_dt"  => date("Y-m-d H:i:s")
  ]
);

$last_post_query = "SELECT * FROM mpd_post
                    WHERE user_id = ?
                    ORDER BY post_dt DESC
                    LIMIT 0,1;";
$last_post = $sql_query($last_post_query, [$_SESSION["u_id"]]);
if (empty($last_post))
  redirect($dimport["home/home_page.php"]["redirect"]."&success=post-submitted");
$last_post = $last_post[0];

redirect($dimport["post/post_page.php"]["redirect"]."&post-id=".$last_post["post_id"]."&success=post-submitted");
