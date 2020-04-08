<?php


namespace App\Modules\User\Application\Query;


use Doctrine\DBAL\Connection;
use Doctrine\DBAL\FetchMode;

class GetUserAllQuery
{
    /**
     * @var Connection
     */
    private $connection;

    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }

    public function execute(array $selectList)
    {
        $stmt = $this->connection->createQueryBuilder()
            ->select($selectList)
            ->from('user_users')
            ->execute();

        $stmt->setFetchMode(FetchMode::STANDARD_OBJECT);

        return $stmt->fetchAll();
    }
}