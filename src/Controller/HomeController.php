<?php

declare(strict_types=1);

namespace App\Controller;

use Pulsar\Framework\Http\Response;
use Pulsar\Framework\Controller\AbstractController;
use App\Widget;

class HomeController extends AbstractController
{
    public function __construct(private Widget $widget)
    {
    }

    public function index(): Response
    {
        return $this->render('home.html.twig');
    }
}