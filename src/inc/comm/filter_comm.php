<?php
$pagin_amt = 25;
$pagin_page = 0;
if (!empty($_GET["step"]) && ctype_digit($_GET["step"]))
    $pagin_page = $_GET["step"];
$pagin_start = $pagin_amt*$pagin_page;

if (!empty($user)) $filters[] = "mpd_comm.user_id = ".$user['user_id'];

if (!empty($post)) $filters[] = "mpd_comm.post_id = ".$post['post_id'];

$order_by  = "comm_dt";
$table     = "mpd_comm";
if (!empty($_GET["sort"]) && $_GET["sort"] == "like") {
    $order_by  = "like_amt";
    $table     = "(SELECT mpd_comm.*, COUNT(mpd_comm_like.comm_id) AS like_amt
                  FROM mpd_comm JOIN mpd_comm_like
                  ON mpd_comm_like.comm_id = mpd_comm.comm_id
                  GROUP BY mpd_comm_like.comm_id) AS mpd_comm";
}

$filter_query = "";
if (!empty($filters)) $filter_query = "WHERE ".implode(" AND ", $filters);
