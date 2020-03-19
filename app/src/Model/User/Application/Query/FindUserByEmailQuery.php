<?php

namespace App\Model\User\Application\Query;

use App\Model\User\Domain\User\ValueObject\Email;

use Doctrine\DBAL\Connection;
use Doctrine\DBAL\FetchMode;

class FindUserByEmailQuery
{
    /**
     * @var Connection
     */
    private $connection;

    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }

    public function execute(string $email, $selectList)
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