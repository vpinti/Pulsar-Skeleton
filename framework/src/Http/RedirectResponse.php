<?php

declare(strict_types=1);

namespace Pulsar\Framework\Http;

class RedirectResponse extends Response
{
    const HTTP_INTERNAL_SERVER_ERROR = 500;

    public function __construct(string $url)
    {
        parent::__construct('', 302, ['location' => $url]);
    }
    
    public function send(): void
    {
        header('Location: ' . $this->getHeader('location'), true, $this->getStatus());
        exit;
    }
}