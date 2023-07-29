<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\User;
use Doctrine\DBAL\Connection;
use Pulsar\Framework\Authentication\AuthRepositoryInterface;
use Pulsar\Framework\Authentication\AuthUserInterface;
use Pulsar\Framework\Http\NotFoundException;

class UserRepository implements AuthRepositoryInterface
{
    public function __construct(private Connection $connection)
    {
    }

    public function findByUsername(string $username): ?AuthUserInterface
    {
        $queryBuilder = $this->connection->createQueryBuilder();

        $queryBuilder
            ->select('id', 'username', 'password', 'created_at')
            ->from('users')
            ->where('username = :username')
            ->setParameter('username', $username);

        $result = $queryBuilder->executeQuery();

        $row = $result->fetchAssociative();

        if(!$row) {
            return null;
        }

        $user = new User(
            id: $row['id'],
            username: $row['username'],
            password: $row['password'],
            createdAt: new \DateTimeImmutable($row['created_at'])
        );

        return $user;
    }

    // public function findOrFail(int $id): User
    // {
    //     $post = $this->findById($id);

    //     if(is_null($post)) {
    //         throw new NotFoundException(sprintf('Post with ID %d not found', $id));
    //     }

    //     return $post;
    // }
}