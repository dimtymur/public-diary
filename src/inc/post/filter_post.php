<?php
$pagin_amt = 25;
$pagin_page = 0;
if (!empty($_GET["step"]) && ctype_digit($_GET["step"])) $pagin_page = $_GET["step"];
$pagin_start = $pagin_amt*$pagin_page;

if (!empty($user)) {
    include_once $dimport["profile/profile_menu.phtml"]["path"];
    $filters[] = "mpd_post.user_id = ".$user["user_id"];
}

$search_val = "";
if (!empty($_GET["search"])) {
    $search_val  = $_GET["search"];
    $filters[]   = "(title LIKE CONCAT('%',?,'%') OR text LIKE CONCAT('%',?,'%'))";
}

if (!empty($_GET["date"])) {
    $dates = [
        "today"  => 1,
        "week"   => 7,
        "month"  => 30,
        "year"   => 365
    ];
    if (isset($dates[$_GET["date"]]))
        $filters[] = "post_dt >= (CURDATE() - INTERVAL ".$dates[$_GET["date"]]." DAY)";
}

$filter_query = "";
if (!empty($filters)) $filter_query = "WHERE ".implode(" AND ", $filters);

$order_by  = "post_dt";
$table     = "mpd_post";
if (!empty($_GET["sort"])) {
    if ($_GET["sort"] == "like") {
        $order_by  = "like_amt";
        $table     = "(SELECT mpd_post.*, COUNT(mpd_post_like.post_id) AS like_amt
                      FROM mpd_post JOIN mpd_post_like
                      ON mpd_post_like.post_id = mpd_post.post_id
                      GROUP BY mpd_post_like.post_id) AS mpd_post";
    } else if ($_GET["sort"] == "comment") {
        $order_by  = "comm_amt";
        $table     = "(SELECT mpd_post.*, COUNT(mpd_comm.post_id) AS comm_amt
                      FROM mpd_post JOIN mpd_comm
                      ON mpd_comm.post_id = mpd_post.post_id
                      GROUP BY mpd_comm.post_id) AS mpd_post";
    }
}
