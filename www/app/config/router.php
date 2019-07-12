<?php

$router = $di->getRouter();

// Define your routes here

if($di->getConfig()->configured) {
  $router->addGet('/',             'Dashboard::index');
  $router->addGet('/admin',        'Admin::index');
  $router->add('/account',         'Account::index')->via(['GET', 'POST']);
  $router->add('/register',        'Account::register')->via(['GET', 'POST']);
  $router->add('/login',           'Account::login')->via(['GET', 'POST']);
  $router->add('/resetpassword',   'Account::recover')->via(['GET', 'POST']);
  $router->addGet('/logout',       'Account::logout');
} else {
  $router->addGet('/', 'Installation::index');
}

$router->handle();
