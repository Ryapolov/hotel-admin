<?php

namespace App\Model\User\Application\Command\Confirm;

use App\Model\User\Application\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;

class Handler
{
    /**
     * @var UserRepository
     */
    private $userRepository;
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    public function __construct(UserRepository $userRepository, EntityManagerInterface $entityManager)
    {
        $this->userRepository = $userRepository;
        $this->entityManager = $entityManager;
    }

    public function handle(Command $command)
    {
        $user = $this->userRepository->getByConfirmToken($command->token);
        $user->confirmByToken();

        $this->entityManager->flush();
    }
}