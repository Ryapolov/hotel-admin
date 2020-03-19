<?php

namespace App\Model\User\Application\Query;

use Doctrine\DBAL\Connection;
use Doctrine\DBAL\FetchMode;

class UserFinder
{
    /**
     * @var Connection
     */
    private $connection;

    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }

    public function findByEmail(string $email, $selectList)
    {
        $stmt = $this->connection->createQueryBuilder()
            ->select($selectList)
            ->from('user_users')
            ->where('email = :email')
            ->setParameter(':email', $email)
            ->execute();

        $stmt->setFetchMode(FetchMode::STANDARD_OBJECT);

        return $stmt->fetch();
    }
}