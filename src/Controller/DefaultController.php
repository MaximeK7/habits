<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends AbstractController
{

    #[Route('/', name: 'home')]
    public function info(): JsonResponse
    {
        return new JsonResponse(
            [
                'version' => 'v1',
            ]
        );
    }

}
