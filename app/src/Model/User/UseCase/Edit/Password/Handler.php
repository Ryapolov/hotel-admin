<?php

namespace App\Model\User\UseCase\Edit\Password;

use App\Model\Flusher;
use App\Model\User\Repository\UserRepository;
use App\Model\User\Service\PasswordHasher;

class Handler
{
    /**
     * @var UserRepository
     */
    private $users;
    /**
     * @var Flusher
     */
    private $flusher;
    /**
     * @var PasswordHasher
     */
    private $passwordHasher;


    /**
     * Handler constructor.
     * @param UserRepository $users
     * @param Flusher $flusher
     * @param PasswordHasher $passwordHasher
     */
    public function __construct(UserRepository $users, Flusher $flusher, PasswordHasher $passwordHasher)
    {
        $this->users = $users;
        $this->flusher = $flusher;
        $this->passwordHasher = $passwordHasher;
    }

    /**
     * @param Command $command
     */
    public function handle(Command $command): void
    {
        $user = $this->users->getByToken($command->token);
        $user->setPassword($this->passwordHasher->getHash($command->password));
        $this->flusher->flush();
    }
}