<?php

$session = $app['session'];
if (!$session->isStarted()) {
    $session->start();
}

