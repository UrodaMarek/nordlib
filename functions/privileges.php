<?php
function get_priv ($session) {
    if ($session === FALSE) {
        return $level = 0;
    }
    
    $level = 1;
    return $level;
}