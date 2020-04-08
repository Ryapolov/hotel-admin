<?php


namespace App\Modules\User\Application\Command\SetPassword;

use App\Modules\User\Application\Repository\UserRepository;
use App\Modules\User\Application\Services\Interfaces\PasswordHasherInterface;
use Doctrine\ORM\EntityManagerInterface;

class SetPasswordHandler
{
    /**
     * @var UserRepository
     */
    private $userRepository;
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;
    /**
     * @var PasswordHasherInterface
     */
    private $passwordHasher;

    public function __construct(
        UserRepository $userRepository,
        EntityManagerInterface $entityManager,
        PasswordHasherInterface $passwordHasher
    )
    {
        $this->userRepository = $userRepository;
        $this->entityManager = $entityManager;
        $this->passwordHasher = $passwordHasher;
    }

    /**
     * @param SetPasswordCommand $command
     * @throws \Doctrine\ORM\EntityNotFoundException
     */
    public function handle(SetPasswordCommand $command): void
    {
        $user = $this->userRepository->get($command->id);

        if (!$user->getStatus()->isActive()) {
            throw new \DomainException('User is no active');
        }

        if ($user->getPassword() !== null) {
            throw new \DomainException('User already has a password');
        }

        $user->setPassword($this->passwordHasher->getHash($command->password));
        $this->entityManager->flush();
    }
}