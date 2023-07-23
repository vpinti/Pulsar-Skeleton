<?php

declare(strict_types=1);

namespace Pulsar\Framework\Http;

class Response
{
    public function __construct(
        private ?string $content = '',
        private int $status = 200,
        private array $headers = []
    )
    {
        http_response_code($this->status);
    }
    
    public function send(): void
    {
        echo $this->content;
    }
}