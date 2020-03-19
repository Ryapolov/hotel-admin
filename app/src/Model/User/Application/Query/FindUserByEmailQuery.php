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

    /**
     * FindByEmailQuery constructor.
     *
     * @param Connection $connection
     */
    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }

    public function execute(Email $email, $selectList)
    {
        $stmt = $this->connection->createQueryBuilder()
            ->select($selectList)
            ->from('user_users')
            ->where('email = :email')
            ->setParameter(':email', $email->getValue())
            ->execute();

        $stmt->setFetchMode(FetchMode::STANDARD_OBJECT);

        return $stmt->fetch();
    }
}