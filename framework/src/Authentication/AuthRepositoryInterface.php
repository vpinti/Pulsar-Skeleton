<?php

namespace Pulsar\Framework\Authentication;

interface AuthRepositoryInterface
{
    public function findByUsername(string $username): ?AuthUserInterface;
}