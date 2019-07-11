<?php

use Phalcon\Loader;
use Phalcon\Events\Event;
use Phalcon\Events\Manager as EventsManager;

$config         = $di->getConfig();
$eventsManager  = new EventsManager();
$loader         = new Loader();

//Register namespaces
$loader->registerNamespaces([
  /**
   * Shoutzor Namespaces
   */
  'Shoutzor\Controller'   => $config->application->controllersDir,
  'Shoutzor\Model'        => $config->application->modelsDir,
  'Shoutzor\Plugin'       => $config->application->pluginsDir,
  'Shoutzor'              => $config->application->appDir . 'core',

  /**
   * Library Namespaces
   */
  'Intervention\Image'    => $config->application->libDir . 'Intervention/Image',
  'Soundasleep'           => $config->application->libDir . 'Html2Text',
]);

//Register some directories to load all classes within
$loader->registerDirs([
  $config->application->libDir . 'GetID3'
]);

//Register some specific classes
$loader->registerClasses([
  'AcoustID' => $config->application->libDir . 'AcoustID/AcoustID.php',
  'LastFM'   => $config->application->libDir . 'LastFM/LastFM.php',
  'Telnet'   => $config->application->libDir . 'Telnet/Telnet.php',
]);

$loader->register();
