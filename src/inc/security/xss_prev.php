<?php
function xss_prev($input) {
    return htmlspecialchars($input, ENT_QUOTES, "UTF-8");
}
