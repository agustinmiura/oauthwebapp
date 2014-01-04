<?php

$debug = true;
if ($debug) {
    $values = array(
        'error_reporting'=>E_ALL,
        'display_errors'=>"1",
        'display_startup_errors'=>"1",
        'log_errors'=>"1",
        'error_log'=>"/home/user/tmp/php/errors/error.log"
    );
    foreach ($values as $key => $value) {
        ini_set($key, $value);
    }
}