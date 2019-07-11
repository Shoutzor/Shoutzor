<?php

namespace Shoutzor\Controller;

class DashboardController extends ControllerBase
{
    public function initialize()
    {
      $this->view->setTemplateAfter('common');
      $this->addBaseAssets();
    }

    public function indexAction()
    {
    }

}
