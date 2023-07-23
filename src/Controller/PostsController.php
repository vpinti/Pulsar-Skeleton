<?php

namespace App\Controller;

use Pulsar\Framework\Http\Response;

class PostsController
{
    public function show(int $id): Response
    {
        $content = "<h1>This is Post $id</h1>";

        return new Response($content);
    }
}