<?php
$db = require __DIR__ . '/db.php';
// test database! Important not to run tests on production or development databases

$db['dsn'] = env('DB_DSN_TEST');
$db['username'] = env('DB_USERNAME_TEST');
$db['password'] = env('DB_PASSWORD_TEST');

return $db;
