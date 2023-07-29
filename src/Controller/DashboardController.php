<?php

declare(strict_types=1);

namespace App\Controller;

use Pulsar\Framework\Http\Response;
use Pulsar\Framework\Controller\AbstractController;
use App\Widget;

class DashboardController extends AbstractController
{
    public function index(): Response
    {
        return $this->render('dashboard.html.twig');
    }
}