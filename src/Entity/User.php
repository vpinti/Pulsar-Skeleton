<?php

declare(strict_types=1);

namespace App\Entity;

use Pulsar\Framework\Authentication\AuthUserInterface;
use Pulsar\Framework\Dbal\Entity;
class User extends Entity implements AuthUserInterface
{
    public function __construct(
        private ?int $id,
        private string $username,
        private string $password,
        private \DateTimeImmutable $createdAt
    )
    {
    }

    public static function create(string $username, string $plainPassword): self
    {
        return new self(
            null,
            $username,
            password_hash($plainPassword, PASSWORD_DEFAULT),
            new \DateTimeImmutable()
        );
    }

    public function getAuthId(): int
    {
        return $this->id;
    }

    public function setId(?int $id): void
    {
        $this->id = $id;
    }

    public function getUsername(): string
    {
        return $this->username;
    }

    public function setUsername(string $username): void
    {
        $this->username = $username;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): void
    {
        $this->password = $password;
    }

    public function getCreatedAt(): \DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): void
    {
        $this->createdAt = $createdAt;
    }
}