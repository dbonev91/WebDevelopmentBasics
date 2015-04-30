<style>
        body {
                background: black;
                color: lightgray;
        }
</style>

<?php
error_reporting(E_ALL ^ E_NOTICE);

include '../../gf/App.php';

$app = \GF\App::getInstance();

$db = new \GF\DB\SimpleDB();
$a = $db->prepare('SELECT * FROM events WHERE id=?', array(2))->execute()->fetchAllAssoc();
print_r($a);

$app->run();