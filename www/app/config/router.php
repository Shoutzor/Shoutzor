<?php

$router = $di->getRouter();

// Define your routes here

if($di->getConfig()->configured) {
  $router->addGet('/',                'Dashboard::index');
  $router->addGet('/admin',           'Admin::index');
  $router->addGet('/account',         'Account::index');
  $router->addGet('/register',        'Account::register');
  $router->addGet('/login',           'Account::login');
  $router->addGet('/restorepassword', 'Account::recover');
} else {
  $router->addGet('/', 'Installation::index');
}

$router->handle();
