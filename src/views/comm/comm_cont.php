<?php if (!empty($comms)) { ?>
    <div class="sort-comm-cont">
        <ul class="sort-comm" name="sort">
            <li class="sort-comm-item" id="new-comm"> Newest </li>
            <li class="sort-comm-item" id="love-comm"> Love </li>
        </ul>
    </div>
<?php }

$query_like   = "SELECT count(*) AS like_amt
                 FROM mpd_comm_like
                 WHERE comm_id = ?;";
$query_liked  = "SELECT count(*) AS like_amt
                 FROM mpd_comm_like
                 WHERE comm_id = ?
                 AND user_id = ?;";

$post_page = $dimport["post/post_page.php"]["redirect"];
foreach ($comms as $comm) {
    $user      = $records_get("mpd_user", "user_id", $comm["user_id"])[0];
    $like_amt  = $sql_query($query_like, [$comm["comm_id"]])[0]["like_amt"];
    $liked     = $sql_query($query_liked, [$comm["comm_id"], $_SESSION["u_id"]])[0]["like_amt"]; ?>
    <div class='media comm' id='<?= $comm["comm_id"] ?>'>
        <div class='media-bar' id='media-bar-top'>
            <a href='index.php?page=profile/profile_page.php&user-id=<?= $user["user_id"] ?>'>
                <img src='/img/icons/profile-icon.png' class='media-bar-item' id='post-profile'>
                <strong id='post-username'> <?= $user["username"] ?> </strong>
            </a>
            <img tabindex='0' src='/img/icons/more-icon.png' class='media-bar-item' id='media-more'>
            <ul class='more-tog-menu'>
                <?php if ($_SESSION["u_id"] == $comm["user_id"]) { ?>
                    <li class='more-tog-menu-item' id='comm-del-btn'> Delete </li>
                    <li class='more-tog-menu-item'
                        id='comm-edit-btn'
                        href='<?= $post_page."&post-id=".$comm["post_id"]."&comm-id=".$comm["comm_id"] ?>'> Edit </li>
                <?php } else { ?>
                    <li class='more-tog-menu-item' id='comm-report-btn'> Report </li>
                <?php } ?>
            </ul>
        </div>
        <div class='media-cont' id="comm-cont">
            <p class='text'> <?= $comm["comm"] ?> </p>
            <p class='text date' id='media-date'> <?= $comm["comm_dt"] ?> </p>
        </div>
        <div class="see-more"> <p class="see-more-text"> See More </p> </div>
        <div class='media-bar' id='media-bar-bottom'>
            <img src='/img/icons/heart-icon.png' class='media-bar-item love-btn' id='comm-love-btn'>
            <em id='like-amt' title='<?= $liked ?>'> <?= $like_amt ?> </em>
            <?php if (empty($post)) { ?>
                <a href="<?= $post_page."&post-id=".$comm["post_id"] ?>">
                    <img src='/img/icons/source-icon.png' class='media-bar-item' id='comm-source-btn'>
                </a>
            <?php } ?>
        </div>
    </div>
<?php }

$alter_form = "comm";
require $dimport["common/alter_forms.php"]["path"];
