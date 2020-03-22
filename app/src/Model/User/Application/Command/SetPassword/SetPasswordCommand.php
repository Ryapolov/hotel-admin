<?php


namespace App\Model\User\Application\Command\SetPassword;

use Symfony\Component\Validator\Constraints as Assert;


class SetPasswordCommand
{
    /**
     * @var string
     * @Assert\NotBlank()
     */
    public $id;
    /**
     * @var string
     * @Assert\NotBlank()
     * @Assert\Length(min="6")
     */
    public $password;
}