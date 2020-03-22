<?php


namespace App\Model\User\Application\Command\Block;


use App\Model\User\Application\Repository\UserRepository;
use App\Model\User\Domain\User\ValueObject\Status;
use Doctrine\ORM\EntityManagerInterface;

class BlockHandler
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
     * @param BlockCommand $command
     * @throws \Doctrine\ORM\EntityNotFoundException
     */
    public function handle(BlockCommand $command): void
    {
        $user = $this->userRepository->get($command->id);

        if ($user->getStatus()->isBlocked()) {
            throw new \DomainException('User is already blocked');
        }

        $user->setStatus(Status::blocked());
        $this->entityManager->flush();
    }
}