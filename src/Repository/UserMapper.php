<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\User;
use Pulsar\Framework\Dbal\DataMapper;

class UserMapper
{
    public function __construct(private DataMapper $dataMapper)
    {
    }

    public function save(User $user): void
    {
        $stmt = $this->dataMapper->getConnection()->prepare("
            INSERT INTO users (username, password, created_at)
            VALUES (:username, :password, :created_at)
        ");

        $stmt->bindValue(':username', $user->getUsername());
        $stmt->bindValue(':password', $user->getPassword());
        $stmt->bindValue(':created_at', $user->getCreatedAt()->format('Y-m-d H:i:s'));

        $stmt->executeStatement();

        $id = (int)$this->dataMapper->save($user);

        $user->setId($id);
    }
}