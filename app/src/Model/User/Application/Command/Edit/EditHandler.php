<?php


namespace App\Model\User\Application\Command\Edit;


use App\Model\User\Application\Query\FindUserByEmailQuery;
use App\Model\User\Application\Repository\UserRepository;
use App\Model\User\Domain\User\ValueObject\Email;
use App\Model\User\Domain\User\ValueObject\Name;
use Doctrine\ORM\EntityManagerInterface;

class EditHandler
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
     * @var FindUserByEmailQuery
     */
    private $findUserByEmailQuery;

    /**
     * EditHandler constructor.
     * @param UserRepository $userRepository
     * @param EntityManagerInterface $entityManager
     * @param FindUserByEmailQuery $findUserByEmailQuery
     */
    public function __construct(
        UserRepository $userRepository,
        EntityManagerInterface $entityManager,
        FindUserByEmailQuery $findUserByEmailQuery
    )
    {
        $this->userRepository = $userRepository;
        $this->entityManager = $entityManager;
        $this->findUserByEmailQuery = $findUserByEmailQuery;
    }

    /**
     * @param EditCommand $editCommand
     * @throws \Doctrine\ORM\EntityNotFoundException
     */
    public function handle(EditCommand $editCommand): void
    {
        $user = $this->userRepository->get($editCommand->id);

        $email = new Email($editCommand->email);
        if (!$user->getEmail()->equals($email) && $this->findUserByEmailQuery->execute($email->getValue(), ['id'])) {
            throw new \DomainException('Email is already in use');
        }

        $user->setEmail(new Email($editCommand->email))
            ->setName(new Name($editCommand->firstName, $editCommand->lastName));

        $this->entityManager->flush();
    }
}