<?php
session_start();
$title   = "Home";
$header  = true;
include_once $dimport["layouts/header.phtml"]["path"];
include_once $dimport["post/posts.php"]["path"];
include_once $dimport["layouts/colcade_import.phtml"]["path"];
include_once $dimport["layouts/footer.phtml"]["path"];
