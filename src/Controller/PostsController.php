<?php

declare(strict_types=1);

namespace App\Controller;

use Pulsar\Framework\Controller\AbstractController;
use Pulsar\Framework\Http\Response;

class PostsController extends AbstractController
{
    public function show(int $id): Response
    {
        return $this->render('post.html.twig', [
            'postId' => $id
        ]);
    }

    public function create(): Response
    {
        return $this->render('create-post.html.twig');
    }
}