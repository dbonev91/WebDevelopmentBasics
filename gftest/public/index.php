<?php
error_reporting(E_ALL ^ E_NOTICE && E_WARNING);

include 'GF/App.php';

$app = \GF\App::getInstance();
session_start();

$app->run();