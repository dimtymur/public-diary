<?php
session_start();
require_once $dimport["auth/accept_auth.php"]["path"];
require_once $dimport["security/csrf_prev.php"]["path"];

$title = "Delete Account";
include_once $dimport["layouts/header.phtml"]["path"];
?>

<div class="mid-cont">
  <form class="main-wrap"
        action="<?= $dimport["user/delete_user_req.php"]["redirect"] ?>"
        method="POST">
    <h1 class="setts-title">
      Do you really want to delete your account?
    </h1>
    <p class="setts-desc">
      Deleting your account will remove all your posts, comments, profile
      information and all the other activities on this website, forever.
    </p>
    <div class="main-wrap" id="setts-sec">
      Password:
      <input name="password" class="main-inp" id="setts-inp" type="password" pattern=".{7,}" required>
      Password (Confirm):
      <input name="password-conf" class="main-inp" id="setts-inp" type="password" pattern=".{7,}" required>
    </div>
    <?= $csrf_form_get ?>
    <button type="submit" name="submit" class="main-btn" id="setts-btn"> Delete Account </button>
  </form>
</div>

<?php
include_once $dimport["layouts/footer.phtml"]["path"];
