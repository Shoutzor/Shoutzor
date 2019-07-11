<?php

$router = $di->getRouter();

// Define your routes here

if($di->getConfig()->configured) {
  $router->addGet('/', 'Dashboard::index');
  $router->addGet('/admin', 'Admin::index');
} else {
  $router->addGet('/', 'Installation::index');
}

$router->handle();
