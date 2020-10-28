<?php
session_start();
require_once $dimport["security/csrf_prev.php"]["path"];
require_once $dimport["inc/gen_funcs.php"]["path"];
require_once $dimport["db/db_funcs.php"]["path"];

if (empty($_GET["user-id"]))
    redirect($dimport["home/home_page.php"]["redirect"]."&error=invalid-user-id");

$user = $records_get("mpd_user", "user_id", $_GET["user-id"]);
if (empty($user)) $get_error_page("User Not Found", "/img/error/nouser.gif");
$user = $user[0];

require_once $dimport["comm/filter_comm.php"]["path"];

$query_comm = "SELECT * FROM $table
               $filter_query
               ORDER BY $order_by DESC
               LIMIT $pagin_start,$pagin_amt;";

$comms = $sql_query($query_comm);

$title = $user["username"]."'s Comments";
include_once $dimport["layouts/header.phtml"]["path"]; ?>

<div class="mid-cont">
    <?php require_once $dimport["comm/comm_cont.php"]["path"] ?>
</div>

<?php
require_once $dimport["common/pagin.php"]["path"];

include_once $dimport["layouts/footer.phtml"]["path"];
