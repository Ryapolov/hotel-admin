<?php

namespace App\Model\User\Application\Command\Confirm;

use App\Model\User\Application\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;

class ConfirmHandler
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

    /**
     * @param ConfirmCommand $command
     * @throws \Doctrine\ORM\EntityNotFoundException
     */
    public function handle(ConfirmCommand $command): void
    {
        $user = $this->userRepository->get($command->id);

        if ($user->getConfirmToken() === null || $user->getStatus()->isActive()) {
            throw new \DomainException('User is already confirm');
        }

        if ($user->getConfirmToken() !== $command->token) {
            throw new \DomainException('Token is no equals');
        }

        $user->confirmByToken();
        $this->entityManager->flush();
    }
}