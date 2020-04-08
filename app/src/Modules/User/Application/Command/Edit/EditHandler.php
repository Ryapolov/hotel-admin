<?php


namespace App\Modules\User\Application\Command\Edit;


use App\Modules\User\Application\Query\FindUserByEmailQuery;
use App\Modules\User\Application\Repository\UserRepository;
use App\Modules\User\Domain\User\ValueObject\Email;
use App\Modules\User\Domain\User\ValueObject\Name;
use App\Modules\User\Domain\User\ValueObject\Role;
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
            ->setName(new Name($editCommand->firstName, $editCommand->lastName))
            ->setRole(new Role($editCommand->role));

        $this->entityManager->flush();
    }
}