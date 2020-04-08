<?php


namespace App\Modules\User\Application\Command\Edit;

use Symfony\Component\Validator\Constraints as Assert;

class EditCommand
{
    /**
     * @Assert\NotBlank()
     */
    public $id;
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
    /**
     * @Assert\NotBlank()
     */
    public $role;

    public function __construct(string $id, string $email, string $firstName, string $lastName, string $role)
    {
        $this->id = $id;
        $this->email = $email;
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->role = $role;
    }
}