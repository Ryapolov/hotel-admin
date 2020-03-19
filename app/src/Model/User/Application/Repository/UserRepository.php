<?php

namespace App\Model\User\Application\Repository;

use App\Model\User\Domain\User\User;
use Doctrine\ORM\EntityManagerInterface;

class UserRepository
{
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function add(User $user): void
    {
        $this->entityManager->persist($user);
    }
}