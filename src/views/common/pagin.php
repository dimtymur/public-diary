<?php
$query_next = "SELECT * FROM $table
               $filter_query
               ORDER BY $order_by DESC
               LIMIT ".($pagin_start+$pagin_amt).",1;";

$next = $sql_query($query_next, [$search_val, $search_val]);
?>

<div class="pagin-cont">
  <?php if ($pagin_page != 0) { ?>
  <img src="/img/icons/arrow-icon.png" class="pagin-arrow" id="pagin-prev">
<?php } if (count($next) == 1) { ?>
  <img src="/img/icons/arrow-icon.png" class="pagin-arrow" id="pagin-next">
  <?php } ?>
</div>
