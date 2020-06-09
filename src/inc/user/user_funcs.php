<?php
require_once $dimport["db/db_funcs.php"]["path"];

$uname_validate = function($uname, $signin=true) use ($records_get) {
  if (empty($uname)) return false;
  if (!preg_match("/^[a-zA-Z0-9_-]{3,20}$/", $uname)) return false;
  $user = $records_get("mpd_user", "username", $uname);
  if ($signin && count($user) > 0) return false;
  else if (!$signin && count($user) != 1) return false;
  return true;
};

$passwd_validate = function($passwd, $passwd_conf="", $signin=true) {
  if (empty($passwd)) return false;
  if (strlen($passwd) < 8) return false;
  if (!empty($passwd_conf)) {
    if ($signin && $passwd != $passwd_conf) return false;
    else if (!$signin && !password_verify($passwd, $passwd_conf)) return false;
  } return true;
};

$email_validate = function($email, $signin=true) use ($records_get) {
  if (empty($email)) return false;
  if (!filter_var($email, FILTER_VALIDATE_EMAIL)) return false;
  $user = $records_get("mpd_user", "email", $email);
  if ($signin && count($user) > 0) return false;
  else if (!$signin && count($user) != 1) return false;
  return true;
};

$email_ver_send = function($user, $url, $subject, $opt=[]) use ($record_add, $records_delete) {
  $records_delete("mpd_email_ver", "user_id", $user["user_id"]);
  $_SESSION["email_token"] = hash_hmac("sha256", "message", bin2hex(random_bytes(32)));
  $timeout = date("Y-m-d H:i:s", strtotime(date("Y-m-d H:i:s")." + 10 minutes"));
  if (empty($opt["sess"]))
    $record_add(
      "mpd_email_ver",
      [
        "user_id"         => $user["user_id"],
        "email_token"     => $_SESSION["email_token"],
        "email_token_dt"  => $timeout
      ]
    );
  else $_SESSION["email_token_dt"] = $timeout;
  $message  = "Your Verification Link: ".$url."&email-token=".$_SESSION["email_token"];
  $email    = empty($opt["email"]) ? $user["email"] : $opt["email"];
  mail($email, "Public Diary | $subject", $message);
};

$email_ver_get = function($user_id) use ($records_get) {
  if (empty($user_id)) return false;
  $email_ver = $records_get("mpd_email_ver", "user_id", $user_id);
  return empty($email_ver) ? false : $email_ver[0];
};

$email_ver_validate = function($email_ver) {
  if (empty($_SESSION["email_token"]) && empty($_GET["email-token"])) return false;
  if ($email_ver["email_token_dt"] < date("Y-m-d H:i:s")) return false;
  if (!hash_equals($email_ver["email_token"], $_GET["email-token"])) return false;
  return true;
};
