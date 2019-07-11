<?php

namespace Shoutzor\Acl;

class RoleLevel
{
  const Guest = 1;
  const User  = 2;
  const Admin = 3;

  //We don't want to allow instancing of this class
  private function __construct(){}
}
