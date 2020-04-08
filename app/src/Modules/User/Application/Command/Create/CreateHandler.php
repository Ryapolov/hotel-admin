<?php

namespace App\Modules\User\Application\Command\Create;

use App\Modules\User\Application\Query\FindUserByEmailQuery;
use App\Modules\User\Application\Repository\UserRepository;
use App\Modules\User\Application\Services\Interfaces\ConfirmTokenSenderInterface;
use App\Modules\User\Application\Services\TokenizerService;
use App\Modules\User\Domain\User\User;
use App\Modules\User\Domain\User\ValueObject\Email;
use App\Modules\User\Domain\User\ValueObject\Id;
use App\Modules\User\Domain\User\ValueObject\Name;
use Doctrine\ORM\EntityManagerInterface;

class CreateHandler
{
    /**
     * @var FindUserByEmailQuery
     */
    private $findUserByEmailQuery;
    /**
     * @var TokenizerService
     */
    private $tokenizerService;
    /**
     * @var UserRepository
     */
    private $userRepository;
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;
    /**
     * @var ConfirmTokenSenderInterface
     */
    private $confirmTokenSender;

    public function __construct(
        FindUserByEmailQuery $findUserByEmailQuery,
        TokenizerService $tokenizerService,
        UserRepository $userRepository,
        EntityManagerInterface $entityManager,
        ConfirmTokenSenderInterface $confirmTokenSender
    )
    {
        $this->findUserByEmailQuery = $findUserByEmailQuery;
        $this->tokenizerService = $tokenizerService;
        $this->userRepository = $userRepository;
        $this->entityManager = $entityManager;
        $this->confirmTokenSender = $confirmTokenSender;
    }

    public function handle(CreateCommand $command)
    {
        $email = new Email($command->email);

        if (!empty($this->findUserByEmailQuery->execute($email->getValue(), ['id']))) {
            throw new \DomainException('User with this email already exists.');
        }

        $user = User::create(
            $id = Id::next(),
            $email,
            new Name($command->firstName, $command->lastName),
            new \DateTimeImmutable(),
            $token = $this->tokenizerService->generate()
        );

        $this->userRepository->add($user);
        $this->entityManager->flush();

        $this->confirmTokenSender->send($email, $token, $id);
    }
}