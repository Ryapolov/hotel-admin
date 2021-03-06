<?php

namespace App\DataFixtures;

use App\Modules\User\Application\Services\PasswordHasherService;
use App\Modules\User\Domain\User\User;
use App\Modules\User\Domain\User\ValueObject\Email;
use App\Modules\User\Domain\User\ValueObject\Id;
use App\Modules\User\Domain\User\ValueObject\Name;
use App\Modules\User\Domain\User\ValueObject\Role;
use App\Modules\User\Domain\User\ValueObject\Status;
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
            ->setStatus(Status::activate())
            ->setRole(Role::admin()
        );

        $manager->persist($user);
        $manager->flush();
    }
}
