<?php
require_once $dimport["db/db_funcs.php"]["path"];

$time = "5M";
$last_post_ts_query = "SELECT * FROM mpd_post
                       WHERE user_id = ?
                       ORDER BY post_ts DESC
                       LIMIT 0,1;";
$last_post_ts = $sql_query($last_post_ts_query, [$_SESSION["u_id"]]);

$last_comm_ts_query = "SELECT * FROM mpd_comm
                       WHERE user_id = ?
                       ORDER BY comm_ts DESC
                       LIMIT 0,1;";
$last_comm_ts = $sql_query($last_comm_ts_query, [$_SESSION["u_id"]]);

$within_time = function(string $time_cell, string $time) : bool {
    $date_time = new DateTime($time_cell);
    $date_time->add(new DateInterval("PT$time"));
    $time_stamp = $date_time->format('Y-m-d H:i:s');

    return $time_stamp > date("Y-m-d H:i:s");
};
