<?php

namespace Shoutzor\Controller;

class AdminController extends ControllerBase
{
  public function initialize()
  {
    $this->view->setTemplateAfter('common');
    $this->addBaseAssets();
  }

  //TODO if $config->installed === true, redirect away from the installation page before processing anything.
  //also TODO: build a proper installation page.

  public function installAction()
  {
    $installer = new \Shoutzor\Database\Installer($this->di->get('db'));
    $installer->createTables();
  }
}
