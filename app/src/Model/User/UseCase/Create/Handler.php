<?php


namespace App\Model\User\UseCase\Create;


use App\Model\Flusher;
use App\Model\User\Entity\User\Email;
use App\Model\User\Entity\User\Id;
use App\Model\User\Entity\User\Name;
use App\Model\User\Entity\User\User;
use App\Model\User\Repository\UserRepository;
use App\Model\User\Service\ConfirmTokenSender;
use App\Model\User\Service\Tokenizer;

class Handler
{
    /**
     * @var UserRepository
     */
    private $users;
    /**
     * @var Tokenizer
     */
    private $tokenizer;
    /**
     * @var Flusher
     */
    private $flusher;
    /**
     * @var ConfirmTokenSender
     */
    private $sender;

    /**
     * Handler constructor.
     * @param UserRepository $users
     * @param Tokenizer $tokenizer
     * @param Flusher $flusher
     * @param ConfirmTokenSender $sender
     */
    public function __construct(UserRepository $users, Tokenizer $tokenizer, Flusher $flusher, ConfirmTokenSender $sender)
    {
        $this->users = $users;
        $this->tokenizer = $tokenizer;
        $this->flusher = $flusher;
        $this->sender = $sender;
    }

    /**
     * @param Command $command
     * @throws \Exception
     */
    public function handle(Command $command): void
    {
        $email = new Email($command->email);
        if ($this->users->hasByEmail($email)) {
            throw new \DomainException('Пользователь с таким email уже существует');
        }

        $user = new User(
            Id::next(),
            $email,
            new Name($command->firstName, $command->lastName),
            new \DateTimeImmutable(),
            $this->tokenizer->generate()
        );

        $this->users->add($user);
        $this->sender->send($user->getEmail(), $user->getConfirmToken());

        $this->flusher->flush();
    }
}