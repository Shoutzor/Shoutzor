<?php

$router = $di->getRouter();

// Define your routes here

$router->addGet('/', 'Dashboard::overview');
$router->addGet('/admin', 'Admin::overview');

$router->handle();
