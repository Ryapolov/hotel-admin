<?php


namespace App\Modules\User\Application\Command\Activate;


use App\Modules\User\Application\Repository\UserRepository;
use App\Modules\User\Application\Repository\UserRepositoryInterface;
use App\Modules\User\Domain\User\ValueObject\Status;
use Doctrine\ORM\EntityManagerInterface;

class ActivateHandler
{
    /**
     * @var UserRepositoryInterface
     */
    private $userRepository;
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    public function __construct(UserRepositoryInterface $userRepository, EntityManagerInterface $entityManager)
    {
        $this->userRepository = $userRepository;
        $this->entityManager = $entityManager;
    }

    /**
     * @param ActivateCommand $command
     * @throws \Doctrine\ORM\EntityNotFoundException
     */
    public function handle(ActivateCommand $command): void
    {
        $user = $this->userRepository->get($command->id);

        if ($user->getStatus()->isActive()) {
            throw new \DomainException('User is already active');
        }

        $user->setStatus(Status::activate());
        $this->entityManager->flush();
    }
}