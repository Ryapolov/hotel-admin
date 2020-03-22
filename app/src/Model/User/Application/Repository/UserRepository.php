<?php

namespace App\Model\User\Application\Repository;

use App\Model\User\Domain\User\User;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityNotFoundException;

class UserRepository
{
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;
    private $repository;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->repository = $entityManager->getRepository(User::class);
    }

    public function add(User $user): void
    {
        $this->entityManager->persist($user);
    }

    /**
     * @param string $id
     * @return User
     * @throws EntityNotFoundException
     */
    public function get(string $id): User
    {
        /** @var User $user */
        if (empty($user = $this->repository->find($id))) {
            throw new EntityNotFoundException('User is not found.');
        }

        return $user;
    }

    /**
     * @param string $token
     *
     * @return User
     * @throws EntityNotFoundException
     */
    public function getByConfirmToken(string $token): User
    {
        /** @var User $user */
        if (empty($user = $this->repository->findOneBy(['confirmToken' => $token]))) {
            throw new EntityNotFoundException('User is not found.');
        }

        return $user;
    }
}