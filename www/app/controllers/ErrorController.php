<?php

namespace Shoutzor\Controller;

class ErrorController extends ControllerBase
{
    public function initialize()
    {
      $this->addBaseAssets(true);
    }

    public function show401Action()
    {
      $this->view->pick('error/401');
      $this->response->setStatusCode(401, "Unauthorized");
    }

    public function show403Action()
    {
      $this->view->pick('error/403');
      $this->response->setStatusCode(403, "Access Denied");
    }

    public function show404Action()
    {
      $this->view->pick('error/404');
      $this->response->setStatusCode(404, "Not Found");
    }

    public function show500Action()
    {
      $this->view->pick('error/500');
      $this->response->setStatusCode(500, "Internal Server Error");
    }
}
