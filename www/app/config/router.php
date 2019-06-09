<?php

$router = $di->getRouter();

// Define your routes here

$router->add(
  '/',
  [
    'controller' => 'dashboard',
    'action' => 'overview'
  ]
);

$router->handle();
