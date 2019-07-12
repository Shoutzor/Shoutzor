<?php

namespace Shoutzor\Acl;

class RoleLevel
{
  const Guest = 0;
  const User  = 1;
  const Admin = 2;

  //We don't want to allow instancing of this class
  private function __construct(){}
}
