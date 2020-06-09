<?php
session_start();
require_once $dimport["db/db_funcs.php"]["path"];
require_once $dimport["inc/gen_funcs.php"]["path"];

if (empty($_GET["user-id"]))
	$get_error_page("404 Not Found", "/img/error/404.gif");

$user = $records_get("mpd_user", "user_id", $_GET["user-id"]);
if (empty($user))
	$get_error_page("User Not Found", "/img/error/nouser.gif");

$user    = $user[0];
$title   = $user["username"];
$header  = true;
include_once $dimport["layouts/header.phtml"]["path"];
include_once $dimport["post/posts.php"]["path"];
include_once $dimport["layouts/colcade_import.phtml"]["path"];
include_once $dimport["layouts/footer.phtml"]["path"];
