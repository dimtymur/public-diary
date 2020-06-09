<?php
session_start();
require_once $dimport["auth/accept_auth.php"]["path"];
require_once $dimport["inc/gen_funcs.php"]["path"];
require_once $dimport["security/csrf_prev.php"]["path"];

if (!csrf_check($csrf_key))
  redirect($dimport["home/home_page.php"]["redirect"]."&error=csrf-error");

if (empty($_POST["media-id"]))
  redirect($dimport["home/home_page.php"]["redirect"]."&error=invalid-post");

require_once $dimport["db/db_funcs.php"]["path"];

$post = $records_get("mpd_post", "post_id", $_POST["media-id"]);
if (empty($post))
  redirect($dimport["home/home_page.php"]["redirect"]."&error=invalid-post");
$post = $post[0];

if ($post["user_id"] != $_SESSION["u_id"])
  redirect($dimport["home/home_page.php"]["redirect"]."&error=invalid-post");

$records_delete("mpd_post", "post_id", $_POST["media-id"]);
redirect($dimport["home/home_page.php"]["redirect"]."&success=post-deleted");
