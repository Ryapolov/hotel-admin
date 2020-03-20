<?php

namespace App\DataFixtures;

use App\Model\User\Application\Services\PasswordHasherService;
use App\Model\User\Domain\User\User;
use App\Model\User\Domain\User\ValueObject\Email;
use App\Model\User\Domain\User\ValueObject\Id;
use App\Model\User\Domain\User\ValueObject\Name;
use App\Model\User\Domain\User\ValueObject\Role;
use App\Model\User\Domain\User\ValueObject\Status;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class UserFixture extends Fixture
{
    /**
     * @var PasswordHasherService
     */
    private $passwordHasher;

    /**
     * UserFixture constructor.
     *
     * @param PasswordHasherService $passwordHasherService
     */
    public function __construct(PasswordHasherService $passwordHasherService)
    {
        $this->passwordHasher = $passwordHasherService;
    }

    /**
     * @inheritDoc
     */
    public function load(ObjectManager $manager)
    {
        $user = User::create(
            Id::next(),
            new Email('admin@mail.ru'),
            new Name('Admin', ''),
            new \DateTimeImmutable(),
            ''
        );
        $user->setPassword($this->passwordHasher->getHash('secret'))
            ->setStatus(Status::activation())
            ->setRole(Role::admin()
        );

        $manager->persist($user);
        $manager->flush();
    }
}
