<?php

namespace Shoutzor\Controller;

class AdminController extends ControllerBase
{
  public function initialize()
  {
    $this->view->setTemplateAfter('common');
    $this->addBaseAssets();
  }

  public function overviewAction()
  {
  }
}
