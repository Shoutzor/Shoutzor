<?php

namespace Shoutzor\Model;

use Phalcon\Mvc\Model;
use Phalcon\Validation;
use Phalcon\Validation\Validator\Email as EmailValidator;
use Phalcon\Validation\Validator\Uniqueness as UniquenessValidator;

class User extends Model
{

  public $id;
  public $username;
  public $email;
  public $role;
  public $verified;
  public $banned;
  public $created;

  public function validation()
  {
    $validator = new Validation();

    $validator->add(
      'email',
      new EmailValidator([
        'message' => 'Invalid email provided'
      ])
    );

    $validator->add(
      'email',
      new UniquenessValidator([
        'message' => 'This email is already in use'
      ])
    );

    $validator->add(
      'username',
      new UniquenessValidator([
        'message' => 'This username is already taken'
      ])
    );

    return $this->validate($validator);
  }

  //TODO very dirty hack to quickly port the permission system originally used in PageKit
  //need to turn this into a proper permission system. But aint got no time for that right now.
  public function hasAccess($permission): bool
  {
    switch($this->role)
    {
        case "Admin":
          if($permission == "shoutzor: manage shoutzor settings") return true;
          if($permission == "shoutzor: manage shoutzor controls") return true;
          if($permission == "shoutzor: manage liquidsoap settings") return true;
        case "User":
          if($permission == "shoutzor: upload files") return true;
          if($permission == "shoutzor: add requests") return true;
        case "Guest":
        default:
          return false;
    }
  }
}
