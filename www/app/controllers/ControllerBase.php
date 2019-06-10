<?php

use Phalcon\Mvc\Controller;

class ControllerBase extends Controller
{
  public function initialize() {
  }

  public function addBaseAssets($cssonly = false) {
    $this->assets->addCss("/assets/css/tabler.io.css");
    $this->assets->addCss("/assets/css/fontawesome.5.9.0.all.min.css");
    $this->assets->addCss("https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,300i,600&amp;subset=latin-ext", false);

    if(!$cssonly) {
      $this->assets->addJs("/assets/js/vendors/require.min.js", true, false, ['async'=>'async']);
      $this->assets->addJs("/assets/js/dashboard.js", true, false, ['async'=>'async']);

      $this->assets->addInlineJs("
        requirejs.config({
            baseUrl: '/'
        });
      ", false, ['defer' => 'defer']);
    }
  }
}
