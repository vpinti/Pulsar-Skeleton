<?php

declare(strict_types=1);

namespace Pulsar\Framework\ServiceProvider;

interface ServiceProviderInterface
{
    public function register(): void;
}