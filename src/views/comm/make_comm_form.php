<?php
$comm_text = "";
if (!empty($_GET["comm-id"])) {
	require_once $dimport["db/db_funcs.php"]["path"];

	$comm = $records_get("mpd_comm", "comm_id", $_GET["comm-id"]);
	if (empty($comm))
		redirect($dimport["home/home_page.php"]["redirect"]."&error=invalid-comm");
	$comm = $comm[0];

	if ($comm["user_id"] != $_SESSION["u_id"])
		redirect($dimport["home/home_page.php"]["redirect"]."&error=invalid-comm");

	$comm_text = $comm["comm"];
	$comm_text = str_replace("~_", "\n", $comm_text);
} ?>

<form class="main-wrap"
	  id="make-comm-form"
	  <?php
	  if ($comm_text) echo "action='".$dimport['comm/edit_comm.php']['redirect']."&comm-id=".$comm['comm_id']."'";
	  else echo "action='".$dimport['comm/make_comm.php']['redirect']."'"; ?>
  	  method="POST">
	<textarea cols="1" class="main-inp" id="comm-inp" type="text" name="comm" pattern=".{0,8000}" placeholder="Comment..." required><?= $comm_text ?></textarea>
	<input type="hidden" name="post-id" value="<?= $post["post_id"] ?>">
	<?= $csrf_form_get ?>
	<button class="main-btn" id="comm-btn" type="submit" name="submit"> Submit </button>
</form>
