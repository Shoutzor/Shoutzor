<?php

$router = $di->getRouter();

// Define your routes here

if($di->getConfig()->configured) {
  $router->addGet('/', 'Dashboard::overview');
  $router->addGet('/admin', 'Admin::overview');
} else {
  $router->addGet('/', 'Installation::setup');
}

$router->handle();
