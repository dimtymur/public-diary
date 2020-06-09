<?php
$query_like   = "SELECT count(*) AS like_amt
                 FROM mpd_post_like
                 WHERE post_id = ?;";
$query_comm   = "SELECT count(*) AS comm_amt
                 FROM mpd_comm
                 WHERE post_id = ?;";
$query_liked  = "SELECT count(*) AS like_amt
                 FROM mpd_post_like
                 WHERE post_id = ?
                 AND user_id = ?;";

$post_page       = $dimport["post/post_page.php"]["redirect"];
$make_post_page  = $dimport["post/make_post_page.php"]["redirect"];
foreach ($posts as $post) {
  $user      = $records_get("mpd_user", "user_id", $post["user_id"])[0];
  $like_amt  = $sql_query($query_like, [$post["post_id"]])[0]["like_amt"];
  $comm_amt  = $sql_query($query_comm, [$post["post_id"]])[0]["comm_amt"];
  $liked     = $sql_query($query_liked, [$post["post_id"], $_SESSION["u_id"]])[0]["like_amt"];
  ?>
  <div class='media post' id='<?= $post["post_id"] ?>'>
    <div class='media-bar' id='media-bar-top'>
      <a href='index.php?page=profile/profile_page.php&user-id=<?= $user["user_id"] ?>'>
        <img src='/img/icons/profile-icon.png' class='media-bar-item' id='post-profile'>
        <strong id='media-username'> <?= $user["username"] ?> </strong>
      </a>
      <img tabindex='0' src='/img/icons/more-icon.png' class='media-bar-item' id='media-more'>
      <ul class='more-tog-menu'>
        <?php if ($_SESSION["u_id"] == $post["user_id"]) { ?>
        <li class='more-tog-menu-item' id='post-del-btn'> Delete </li>
        <li class='more-tog-menu-item'
            id='post-edit-btn'
            href='<?= $make_post_page."&post-id=".$post["post_id"] ?>'> Edit </li>
        <?php } else { ?>
        <li class='more-tog-menu-item' id='post-report-btn'> Report </li>
        <?php } ?>
      </ul>
    </div>
    <div class='media-cont' id="post-cont">
      <h3 class='title'> <?= $post["title"] ?> </h3>
      <p class='text'> <?= $post["text"] ?> </p>
      <p class='text date' id='media-date'> <?= $post["post_dt"] ?> </p>
    </div>
    <div class="see-more">
      <p class="see-more-text"> See More </p>
    </div>
    <div class='media-bar' id='media-bar-bottom'>
      <img src='/img/icons/heart-icon.png' class='media-bar-item love-btn' id='post-love-btn'>
      <em id='like-amt' title='<?= $liked ?>'> <?= $like_amt ?> </em>
      <a href="<?= $post_page."&post-id=".$post["post_id"] ?>">
        <img src='/img/icons/comm-icon.png' class='media-bar-item' id='post-comm-btn'>
        <em id="comm-amt"> <?= $comm_amt ?> </em>
      </a>
    </div>
  </div>
<?php }

$alter_form = "post";
require $dimport["common/alter_forms.php"]["path"];
