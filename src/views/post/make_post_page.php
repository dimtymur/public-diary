<?php
session_start();
require_once $dimport["auth/accept_auth.php"]["path"];
require_once $dimport["security/csrf_prev.php"]["path"];

$title = "Post";
include_once $dimport["layouts/header.phtml"]["path"];

if (!empty($_GET["post-id"])) {
	require_once $dimport["db/db_funcs.php"]["path"];

	$post = $records_get("mpd_post", "post_id", $_GET["post-id"]);
	if (empty($post))
	  redirect($dimport["home/home_page.php"]["redirect"]."&error=no-such-post");
	$post = $post[0];

	if ($post["user_id"] != $_SESSION["u_id"])
	  redirect($dimport["home/home_page.php"]["redirect"]."&error=not-your-post");

	$post_title  = $post["title"];
	$post_title  = str_replace("~_", "\n", $post_title);
	$post_text   = $post["text"];
	$post_text   = str_replace("~_", "\n", $post_text);
} ?>

<form class="main-wrap"
			id="post-wrap"
			<?php
			if (!empty($post_title) && !empty($post_text))
				echo "action='".$dimport['post/edit_post.php']['redirect']."&post-id=".$post['post_id']."'";
			else
				echo "action='".$dimport['post/make_post.php']['redirect']."'";
			?>
			method="POST">
	Title:
	<input name="title" class="main-inp" id="title-inp" value="<?= $post_title ?>" pattern=".{0,100}" required>
	<br>
	<br>
	Text:
	<textarea cols="1" name="text" class="main-inp" id="text-inp" pattern=".{0,10000}" required><?= $post_text ?></textarea>
	<?= $csrf_form_get ?>
	<button type="submit" name="submit" class="main-btn" id="post-btn"> Post </button>
</form>

<?php
include_once $dimport["layouts/footer.phtml"]["path"];
