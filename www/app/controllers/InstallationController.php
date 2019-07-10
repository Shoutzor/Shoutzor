<?php

namespace Shoutzor\Controller;

class InstallationController extends ControllerBase
{
  public function initialize()
  {
    $this->addBaseAssets(true);
  }

  public function setupAction()
  {
    $this->view->pick('installation/databaseConnection');
    $this->view->pick('installation/newAdminUser');
    // $installer = new \Shoutzor\Database\Installer($this->di->get('db'));
    // $installer->createTables();
  }
}
