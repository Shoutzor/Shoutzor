<?php

use Phalcon\Config\Adapter\Ini as ConfigIni;
use Phalcon\Mvc\View;
use Phalcon\Mvc\Dispatcher;
use Phalcon\Mvc\View\Engine\Php as PhpEngine;
use Phalcon\Mvc\Url as UrlResolver;
use Phalcon\Mvc\View\Engine\Volt as VoltEngine;
use Phalcon\Mvc\Model\Metadata\Memory as MetaDataAdapter;
use Phalcon\Session\Adapter\Files as SessionAdapter;
use Phalcon\Flash\Session as Flash;
use Phalcon\Events\Manager as EventsManager;

use Shoutzor\Database\Connection as DatabaseConnection;

use Shoutzor\Plugin\ErrorHandlerPlugin;
use Shoutzor\Plugin\SecurityPlugin;

/**
 * Shared configuration service
 */
$di->setShared('config', function () {
  //Load the default config
  $config = include APP_PATH . "/config/config.default.php";

  //Check if a custom config exists and merge it's properties if required.
  if(file_exists($config->application->etcDir . 'config.ini'))
  {
    $config2 = new ConfigIni($config->application->etcDir . 'config.ini');
    $config->merge($config2);

    //A custom config has been found, set the state of CONFIGURED to TRUE.
    $config->offsetSet("configured", true);
  }

  return $config;
});

/**
 * The URL component is used to generate all kind of urls in the application
 */
$di->setShared('url', function () {
  $config = $this->getConfig();

  $url = new UrlResolver();
  $url->setBaseUri($config->application->baseUri);

  return $url;
});

/**
 * Dispatcher use a default namespace
 */
$di->set('dispatcher', function () {
  $eventsManager = new EventsManager();

  //Check if the user is allowed to access certain action using the SecurityPlugin
  $eventsManager->attach('dispatch:beforeExecuteRoute', new SecurityPlugin);

  //Handle any exceptions and routing-errors
  $eventsManager->attach('dispatch:beforeException', new ErrorHandlerPlugin);

  $dispatcher = new Dispatcher();
  $dispatcher->setDefaultNamespace('Shoutzor\Controller');
  $dispatcher->setEventsManager($eventsManager);
  return $dispatcher;
});

/**
 * Database connection is created based in the parameters defined in the configuration file
 */
$di->setShared('db', function () {
  $db = new DatabaseConnection($this->getConfig());

  $config = $this->getConfig();

  if($config->configured === true)
  {
    $db->connect();
  }

  return $db->getConnection();
});


/**
 * If the configuration specify the use of metadata adapter use it or use memory otherwise
 */
$di->setShared('modelsMetadata', function () {
  return new MetaDataAdapter();
});

/**
 * Register the session flash service with the Twitter Bootstrap classes
 */
$di->set('flash', function () {
  return new Flash([
    'error'   => 'alert alert-danger',
    'success' => 'alert alert-success',
    'notice'  => 'alert alert-info',
    'warning' => 'alert alert-warning'
  ]);
});

/**
 * Start the session the first time some component request the session service
 */
$di->setShared('session', function () {
  $session = new SessionAdapter();
  $session->start();

  return $session;
});

/**
 * Setting up the view component
 */
$di->setShared('view', function () {
  $config = $this->getConfig();

  $view = new View();
  $view->setDI($this);
  $view->setViewsDir($config->application->viewsDir);

  $view->registerEngines([
    '.volt' => function ($view) {
      $config = $this->getConfig();
      $volt   = new VoltEngine($view, $this);

      $volt->setOptions([
        'compiledPath' => $config->application->cacheDir,
        'compiledSeparator' => '_'
      ]);

      return $volt;
    },
    '.phtml' => PhpEngine::class
  ]);

  $session = $this->getShared('session');
  $auth    = $session->get('auth');

  //Set global view variables
  $view->setVar("auth", ($auth == null ? false : $auth));
  $view->setVar("flash", $this->getShared('flash'));

  return $view;
});
