<?php

namespace Shoutzor\Acl;

use Phalcon\Acl\Role as PhalconRole;

class Role extends PhalconRole
{
  private $roleLevel;

  public function __construct(int $roleLevel)
  {
    //TODO semi-dirty solution due to time-pressure
    switch($roleLevel)
    {
      case RoleLevel::User:
        $name = 'User';
        $desc = 'Member privileges, granted after sign in.';
        break;

      case RoleLevel::Admin:
        $name = 'Admin';
        $desc = 'Administrator privileges, granted after sign in.';
        break;

      default:
        $name       = 'Guest';
        $desc       = 'Anyone browsing the site who is not signed in is considered to be a "Guest".';
        $roleLevel  = RoleLevel::Guest;
        break;
    }

    parent::__construct($name, $desc);

    $this->roleLevel = $roleLevel;
  }

  public function getRoleLevel(): RoleLevel
  {
    return $this->roleLevel;
  }
}
