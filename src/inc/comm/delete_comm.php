<?php
session_start();
require_once $dimport["auth/accept_auth.php"]["path"];
require_once $dimport["inc/gen_funcs.php"]["path"];
require_once $dimport["security/csrf_prev.php"]["path"];

if (!csrf_check($csrf_key))
  redirect($dimport["home/home_page.php"]["redirect"]."&error=csrf-error");

if (empty($_POST["media-id"]))
  redirect($dimport["home/home_page.php"]["redirect"]."&error=invalid-comm");

require_once $dimport["db/db_funcs.php"]["path"];

$comm = $records_get("mpd_comm", "comm_id", $_POST["media-id"]);
if (empty($comm))
  redirect($dimport["home/home_page.php"]["redirect"]."&error=invalid-comm");
$comm = $comm[0];

if ($comm["user_id"] != $_SESSION["u_id"])
  redirect($dimport["home/home_page.php"]["redirect"]."&error=invalid-comm");

$records_delete("mpd_comm", "comm_id", $_POST["media-id"]);
redirect($dimport["home/home_page.php"]["redirect"]."&success=comm-deleted");
