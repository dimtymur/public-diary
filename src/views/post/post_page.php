<?php
session_start();
require_once $dimport["security/csrf_prev.php"]["path"];
require_once $dimport["inc/gen_funcs.php"]["path"];
require_once $dimport["db/db_funcs.php"]["path"];

if (empty($_GET["post-id"]))
    redirect($dimport["home/home_page.php"]["redirect"]."&error=invalid-post-id");

$posts = $records_get("mpd_post", "post_id", $_GET["post-id"]);
if (empty($posts)) $get_error_page("Post Not Found", "/img/error/nopost.gif");
$post = $posts[0];

require_once $dimport["comm/filter_comm.php"]["path"];

$query_comm = "SELECT * FROM $table
               $filter_query
               ORDER BY $order_by DESC
               LIMIT $pagin_start,$pagin_amt;";

$comms = $sql_query($query_comm);

$title = $post["title"];
include_once $dimport["layouts/header.phtml"]["path"]; ?>

<div class="mid-cont">
    <?php
    require_once $dimport["post/post_cont.php"]["path"];
    require_once $dimport["comm/make_comm_form.php"]["path"];
    require_once $dimport["comm/comm_cont.php"]["path"];
    ?>
</div>

<?php
require_once $dimport["common/pagin.php"]["path"];

include_once $dimport["layouts/footer.phtml"]["path"];
