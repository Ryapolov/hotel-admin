<?php


namespace App\Model\User\UseCase\Confirm;


use App\Model\Flusher;
use App\Model\User\Entity\User\Status;
use App\Model\User\Repository\UserRepository;

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

    public function __construct(UserRepository $userRepository, Flusher $flusher)
    {
        $this->users = $userRepository;
        $this->flusher = $flusher;
    }

    public function handle(Command $command)
    {
        $user = $this->users->getByToken($command->token);
        $user->setStatus(Status::activation());

        $this->flusher->flush();
    }
}