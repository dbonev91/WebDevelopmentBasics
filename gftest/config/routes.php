<?php
$cnf['adm']['namespace'] = 'Controllers\Admin';
$cnf['adm']['controllers']['index']['to'] = 'Index';
$cnf['adm']['controllers']['index']['methods']['new'] = 'otherMethod';

$cnf['user']['namespace'] = 'Controllers';
$cnf['user']['controllers']['profile']['to'] = 'index';
$cnf['user']['controllers']['profile']['methods']['show'] = 'index3';

// Blog

// Registration

// Registration form
$cnf['blog']['namespace'] = 'Controllers\Blog';
$cnf['blog']['controllers']['registration']['to'] = 'register';
$cnf['blog']['controllers']['registration']['methods']['reg'] = 'showRegisterForm';
// Do Register
$cnf['blog']['namespace'] = 'Controllers\Blog';
$cnf['blog']['controllers']['registration']['to'] = 'register';
$cnf['blog']['controllers']['registration']['methods']['doReg'] = 'doReg';

// Login

// Login form
$cnf['blog']['namespace'] = 'Controllers\Blog';
$cnf['blog']['controllers']['login']['to'] = 'login';
$cnf['blog']['controllers']['login']['methods']['show'] = 'showLoginForm';

// Do log
$cnf['blog']['namespace'] = 'Controllers\Blog';
$cnf['blog']['controllers']['login']['to'] = 'login';
$cnf['blog']['controllers']['login']['methods']['doLog'] = 'doLog';

// Logout
$cnf['blog']['namespace'] = 'Controllers\Blog';
$cnf['blog']['controllers']['logout']['to'] = 'login';
$cnf['blog']['controllers']['logout']['methods']['logout'] = 'logout';

// Users

// View profile
$cnf['blog']['namespace'] = 'Controllers\Blog';
$cnf['blog']['controllers']['profile']['to'] = 'ViewProfile';
$cnf['blog']['controllers']['profile']['methods']['view'] = 'viewProfile';

// Posts

// View addPost form
$cnf['blog']['namespace'] = 'Controllers\Blog';
$cnf['blog']['controllers']['post']['to'] = 'post';
$cnf['blog']['controllers']['post']['methods']['form'] = 'addPostForm';

// Do add post
$cnf['blog']['namespace'] = 'Controllers\Blog';
$cnf['blog']['controllers']['post']['to'] = 'post';
$cnf['blog']['controllers']['post']['methods']['add'] = 'addPost';

$cnf['*']['namespace'] = 'Controllers';

return $cnf;