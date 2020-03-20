<?php

namespace App\Model\User\Application\Command\Confirm;

use Symfony\Component\Validator\Constraints as Assert;

class Command
{
    /**
     * @Assert\NotBlank()
     */
    public $token;
}