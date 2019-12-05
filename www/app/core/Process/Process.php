<?php

namespace Shoutzor\Process;

interface Process {

  public function getPID() : int;

  public function start() : void;
  public function stop() : void;

  public function isRunning() : bool;

}
