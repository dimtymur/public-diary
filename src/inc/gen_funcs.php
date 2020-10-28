<?php
function redirect($path) {
	header("Location: ".$path); exit();
}

function get($name, $def="") {
	return isset($_REQUEST[$name]) ? $_REQUEST[$name] : $def;
}

$get_error_page = function($title, $error_img) use ($dimport) {
	require_once $dimport["error/error_page.php"]["path"]; exit();
};
