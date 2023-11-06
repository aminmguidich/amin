<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AmineController extends AbstractController
{
    #[Route('/amine', name: 'app_amine')]
    public function index(): Response
    {
        return $this->render('amine/index.html.twig', [
            'controller_name' => 'AmineController',
        ]);
    }
}
