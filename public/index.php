<?php
const NEWLINER = "~_";

require_once dirname($_SERVER["DOCUMENT_ROOT"]).DIRECTORY_SEPARATOR."autoloader.php";
require_once $dimport["inc/gen_funcs.php"]["path"];
// require_once $dimport["debug/error_show.php"]["path"];

$page = get("page", "home/home_page.php");
if (file_exists($dimport[$page]["path"])) require_once $dimport[$page]["path"];
else $get_error_page("404 Not Found", "/img/error/404.gif");
