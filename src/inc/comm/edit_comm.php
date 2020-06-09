<?php
session_start();
require_once $dimport["auth/accept_auth.php"]["path"];
require_once $dimport["inc/gen_funcs.php"]["path"];
require_once $dimport["security/csrf_prev.php"]["path"];

if (!csrf_check($csrf_key))
  redirect($dimport["home/home_page.php"]["redirect"]."&error=csrf-error");

if (empty($_POST['post-id']))
  redirect($dimport["home/home_page.php"]["redirect"]."&error=invalid-post");

require_once $dimport["db/db_funcs.php"]["path"];

$post = $records_get("mpd_post", "post_id", $_POST["post-id"]);
if (empty($post))
  redirect($dimport["home/home_page.php"]["redirect"]."&error=invalid-post");
$post = $post[0];

$post_id_uri = "&post-id=".$post['post_id'];

if (empty($_GET["comm-id"]))
  redirect($dimport["post/post_page.php"]["redirect"]."$post_id_uri&error=invalid-comm");

$comm = $records_get("mpd_comm", "comm_id", $_GET["comm-id"]);
if (empty($comm))
  redirect($dimport["post/post_page.php"]["redirect"]."$post_id_uri&error=invalid-comm");
$comm = $comm[0];

if ($comm["user_id"] != $_SESSION["u_id"])
  redirect($dimport["post/post_page.php"]["redirect"]."$post_id_uri&error=invalid-comm");

require_once $dimport["security/xss_prev.php"]["path"];

if (empty($_POST["comm"]))
  redirect($dimport["post/post_page.php"]["redirect"]."$post_id_uri&error=invalid-input");

$comm_text = xss_prev(trim($_POST["comm"]));
$comm_text = str_replace("~_", "\n", $comm_text);

if (!(strlen($comm_text) < 8000))
  redirect($dimport["post/post_page.php"]["redirect"]."$post_id_uri&error=invalid-input");

$records_edit(
  "mpd_comm",
  "comm_id",
  $comm["comm_id"],
  ["comm" => $comm_text]
);
redirect($dimport["post/post_page.php"]["redirect"]."$post_id_uri&success=comm-edited");
