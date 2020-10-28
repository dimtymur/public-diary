<?php
$post_like_amt = "SELECT count(*) AS like_amt
                  FROM mpd_post_like JOIN mpd_post
                  ON mpd_post_like.post_id = mpd_post.post_id
                  AND mpd_post.user_id = ?;";
$comm_like_amt = "SELECT count(*) AS like_amt
                  FROM mpd_comm_like JOIN mpd_comm
                  ON mpd_comm_like.comm_id = mpd_comm.comm_id
                  AND mpd_comm.user_id = ?;";

$post_like_amt = $sql_query($post_like_amt, [$user["user_id"]])[0]["like_amt"];
$comm_like_amt = $sql_query($comm_like_amt, [$user["user_id"]])[0]["like_amt"];

$like_amt = $post_like_amt + $comm_like_amt;

$comm_page   = $dimport["comm/comm_page.php"]["redirect"];
$setts_page  = $dimport["setts/setts_page.php"]["redirect"]; ?>
<div class='media post'>
    <div class='profile-info'>
        <div class='profile-item'> <img id='profile-icon' src='/img/icons/profile-icon.png'> </div>
        <div class='profile-item'> <h3 class='profile-desc'> <?= $user['username'] ?> </h3> </div>
        <div class='profile-item'>
            <h3 class='profile-title'>
                <img class='media-bar-item' id="profile-item-icon" src='/img/icons/heart-icon.png'>
                <?= $like_amt; ?>
            </h3>
            <h3 class='profile-title'>
                <img class='media-bar-item' id="profile-item-icon" src='/img/icons/cake-icon.png'>
                <strong class="date"> <?= $user['user_dt'] ?> </strong>
            </h3>
        </div>
        <div class='profile-item'>
            <?php if ($user["user_id"] == $_SESSION["u_id"]) { ?>
                <a href="<?= $setts_page ?>">
                    <button class='main-btn' id='setts-btn'> Settings </button>
                </a>
            <?php } ?>
            <a href="<?= $comm_page."&user-id=".$user['user_id'] ?>">
                <button class='main-btn' id='comments-btn'> Comments </button>
            </a>
        </div>
    </div>
</div>
