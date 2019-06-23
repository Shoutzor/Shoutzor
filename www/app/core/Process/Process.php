<?php

namespace Shoutzor\Process;

interface Process {

  public int getPID();

  public void start();
  public void stop();

  public boolean isRunning();

}
