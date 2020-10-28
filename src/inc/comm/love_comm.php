<?php
session_start();
require_once $dimport["auth/accept_auth.php"]["path"];
require_once $dimport["inc/gen_funcs.php"]["path"];
require_once $dimport["security/csrf_prev.php"]["path"];

if (!csrf_check($csrf_key))
    redirect($dimport["home/home_page.phtml"]["redirect"]."&error=csrf-error");

if (empty($_POST["media-id"]))
    redirect($dimport["home/home_page.phtml"]["redirect"]."&error=invalid-comm");

require_once $dimport["db/db_funcs.php"]["path"];

$comm = $records_get("mpd_comm", "comm_id", $_POST["media-id"]);
if (empty($comm))
    redirect($dimport["home/home_page.phtml"]["redirect"]."&error=invalid-comm");
$comm = $comm[0];

$query_like = "SELECT * FROM mpd_comm_like
               WHERE comm_id = ? AND user_id = ?;";
$like = $sql_query($query_like, [$comm["comm_id"], $_SESSION["u_id"]]);

if (empty($like)) {
    $record_add(
        "mpd_comm_like",
        ["comm_id" => $comm["comm_id"], "user_id" => $_SESSION["u_id"]]
    );
    redirect($dimport["home/home_page.phtml"]["redirect"]."&success=comm-loved");
}

$query_unlike = "DELETE FROM mpd_comm_like
                 WHERE comm_id = ? AND user_id = ?;";
$sql_query($query_unlike, [$comm["comm_id"], $_SESSION["u_id"]]);

redirect($dimport["home/home_page.phtml"]["redirect"]."&success=comm-unloved");
