<?php require_once $dimport["db/db_funcs.php"]["path"];

$time = "3M";
$last_post_ts_query = "SELECT * FROM mpd_post
                       WHERE user_id = ?
                       ORDER BY post_ts DESC
                       LIMIT 0,1;";
$last_post_ts = $sql_query($last_post_ts_query, [$_SESSION["u_id"]]);

$last_comment_ts_query = "SELECT * FROM comment
                       WHERE user_id = ?
                       ORDER BY comment_ts DESC
                       LIMIT 0,1;";
$last_comment_ts = $sql_query($last_comment_ts_query, [$_SESSION["u_id"]]);

$within_time = function(string $time_cell, string $time) : bool {
    $date_time = new DateTime($time_cell);
    $date_time->add(new DateInterval("PT".$time));
    return $date_time->format('Y-m-d H:i:s') > date("Y-m-d H:i:s");
};
