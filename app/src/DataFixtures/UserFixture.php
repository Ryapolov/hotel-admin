<?php

namespace App\DataFixtures;

use App\Model\User\Entity\User\Email;
use App\Model\User\Entity\User\Id;
use App\Model\User\Entity\User\Name;
use App\Model\User\Entity\User\Role;
use App\Model\User\Entity\User\Status;
use App\Model\User\Entity\User\User;
use App\Model\User\Service\PasswordHasher;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class UserFixture extends Fixture
{
    /**
     * @var PasswordHasher
     */
    private $passwordHasher;

    public function __construct(PasswordHasher $passwordHasher)
    {
        $this->passwordHasher = $passwordHasher;
    }

    /**
     * @inheritDoc
     */
    public function load(ObjectManager $manager)
    {
        $user = new User(Id::next(), new Email('admin@mail.ru'), new Name('Admin', ''), new \DateTimeImmutable(), '');
        $user->setPassword($this->passwordHasher->getHash('secret'));
        $user->setStatus(Status::activation());
        $user->setRole(Role::admin());

        $manager->persist($user);
        $manager->flush();
    }
}
