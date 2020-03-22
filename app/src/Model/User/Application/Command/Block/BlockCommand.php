<?php


namespace App\Model\User\Application\Command\Block;

use Symfony\Component\Validator\Constraints as Assert;

class BlockCommand
{
    /**
     * @var string
     * @Assert\NotBlank()
     */
    public $id;
}