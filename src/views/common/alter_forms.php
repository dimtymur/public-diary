<?php
$alter = [
    "post" => [
        "delete"  => $dimport['post/delete_post.php']['redirect'],
        "love"    => $dimport['post/love_post.php']['redirect']
    ],
    "comm" => [
        "delete"  => $dimport['comm/delete_comm.php']['redirect'],
        "love"    => $dimport['comm/love_comm.php']['redirect']
    ]
]; ?>

<form id="<?= "$alter_form-delete-form" ?>"
      style="display: none;"
      action="<?= $alter[$alter_form]["delete"] ?>"
      method="POST">
    <input type="text" name="media-id">
    <?= $csrf_form_get ?>
    <button type="submit" name="submit"></button>
</form>

<form id="<?= "$alter_form-love-form" ?>"
      style="display: none;"
      action="<?= $alter[$alter_form]["love"] ?>"
      method="POST">
    <input type="text" name="media-id">
    <?= $csrf_form_get ?>
    <button type="submit" name="submit"></button>
</form>
