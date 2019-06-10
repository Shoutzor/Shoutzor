<?php

class ErrorController extends ControllerBase
{
    public function initialize()
    {
      //$this->view->setTemplateAfter('index');
      $this->addBaseAssets(true);
    }

    public function 404Action()
    {
    }

    public function 500Action()
    {
    }
}
