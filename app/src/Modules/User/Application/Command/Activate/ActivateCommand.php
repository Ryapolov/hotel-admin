<?php


namespace App\Modules\User\Application\Command\Activate;

use Symfony\Component\Validator\Constraints as Assert;


class ActivateCommand
{
    /**
     * @var string
     * @Assert\NotBlank()
     */
    public $id;
}