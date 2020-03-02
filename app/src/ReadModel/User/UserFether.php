<?php


namespace App\ReadModel\User;


use App\Model\User\Entity\User\User;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\FetchMode;
use Doctrine\ORM\EntityManagerInterface;

class UserFether
{
    private $connection;
    private $repository;

    public function __construct(Connection $connection, EntityManagerInterface $em)
    {
        $this->connection = $connection;
        //$this->repository = $em->getRepository(User::class);
    }

    public function findForAuthByEmail(string $email): ?AuthDTO
    {
        $stmt = $this->connection->createQueryBuilder()
            ->select(
                'id',
                'email',
                'password',
                'role',
                'status'
            )
            ->from('user_users')
            ->where('email = :email')
            ->setParameter(':email', $email)
            ->execute();

        $stmt->setFetchMode(FetchMode::CUSTOM_OBJECT, AuthDTO::class);
        $result = $stmt->fetch();

        return $result ?: null;
    }
}