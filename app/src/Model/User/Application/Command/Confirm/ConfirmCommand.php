<?php

namespace App\Model\User\Application\Command\Confirm;

use Symfony\Component\Validator\Constraints as Assert;

class ConfirmCommand
{
    /**
     * @var string
     * @Assert\NotBlank()
     */
    public $id;
    /**
     * @var string
     * @Assert\NotBlank()
     */
    public $token;
}