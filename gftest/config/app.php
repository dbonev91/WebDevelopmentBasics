<?php

$cnf['default_controller'] = 'Index';
$cnf['default_method'] = 'index3';
$cnf['namespaces']['Controllers'] = '../controllers/';

$cnf['session']['autostart'] = true;
$cnf['session']['type'] = 'native';
$cnf['session']['name'] = '__sess';
$cnf['session']['lifetime'] = 3600;
$cnf['session']['path'] = '/';
$cnf['session']['domain'] = '';
$cnf['session']['secure'] = false;

return $cnf;