<?php

declare(strict_types=1);

namespace Pulsar\Framework\Controller;

use Psr\Container\ContainerInterface;
use Pulsar\Framework\Http\Response;

abstract class AbstractController
{
    protected ?ContainerInterface $container = null;
    
    public function setContainer(ContainerInterface $container): void
    {
        $this->container = $container;
    }

    public function render(string $template, array $parameters = [], Response $response = null): Response
    {
        $content = $this->container->get('twig')->render($template, $parameters);

        $response ??= new Response();

        $response->setContent($content);

        return $response;
    }
}