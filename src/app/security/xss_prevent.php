<?php
function xss_prevent($input) {
    return htmlspecialchars($input, ENT_QUOTES, "UTF-8");
}
