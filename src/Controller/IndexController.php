<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class IndexController extends AbstractController
{
    /**
     * Handles index request but redirect to our customers endpoint
     *
     * @return Response
     */
    #[Route('/')]
    public function index(): Response
    {
        return $this->redirect('/customers');
    }
}
