<div class="post-wrap">
    <div class="post-col post-col--1"></div>
    <div class="post-col post-col--2"></div>
    <div class="post-col post-col--3"></div>
    <?php
    require_once $dimport["db/db_funcs.php"]["path"];
    require_once $dimport["security/csrf_prev.php"]["path"];

    require_once $dimport["post/filter_post.php"]["path"];
    $query_post = "SELECT * FROM $table
                   $filter_query
                   ORDER BY $order_by DESC
                   LIMIT $pagin_start,$pagin_amt;";

    $posts = $sql_query($query_post, [$search_val, $search_val]);
    require_once $dimport["post/post_cont.php"]["path"];
    ?>
</div>

<?php require_once $dimport["common/pagin.php"]["path"];
