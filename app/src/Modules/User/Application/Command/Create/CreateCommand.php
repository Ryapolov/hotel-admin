<?php

namespace App\Modules\User\Application\Command\Create;

use Symfony\Component\Validator\Constraints as Assert;

class CreateCommand
{
    /**
     * @Assert\NotBlank()
     * @Assert\Email()
     */
    public $email;
    /**
     * @Assert\NotBlank()
     */
    public $firstName;
    /**
     * @Assert\NotBlank()
     */
    public $lastName;
}