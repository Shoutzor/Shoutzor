<?php

namespace Shoutzor\Form;

use Phalcon\Forms\Form;
use Phalcon\Forms\Element\Text;
use Phalcon\Forms\Element\Password;
use Phalcon\Validation\Validator\PresenceOf;
use Phalcon\Validation\Validator\Email;

class Register extends Form
{
    public function initialize($entity = null, $options = null)
    {
        // Name
        $name = new Text('username');
        $name->setLabel('Username');
        $name->setFilters(['alphanum']);
        $name->addValidators([
            new PresenceOf([
                'message' => 'Please enter your desired user name'
            ])
        ]);
        $this->add($name);

        // Email
        $email = new Text('email');
        $email->setLabel('E-Mail');
        $email->setFilters('email');
        $email->addValidators([
            new PresenceOf([
                'message' => 'E-mail is required'
            ]),
            new Email([
                'message' => 'E-mail is not valid'
            ])
        ]);
        $this->add($email);

        // Password
        $password = new Password('password');
        $password->setLabel('Password');
        $password->addValidators([
            new PresenceOf([
                'message' => 'Password is required'
            ])
        ]);
        $this->add($password);

        // Confirm Password
        $repeatPassword = new Password('password-repeat');
        $repeatPassword->setLabel('Password (Repeat)');
        $repeatPassword->addValidators([
            new PresenceOf([
                'message' => 'Confirmation password is required'
            ])
        ]);
        $this->add($repeatPassword);
    }
}
