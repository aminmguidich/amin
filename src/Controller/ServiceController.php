<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ServiceController extends AbstractController
{
    #[Route('/service', name: 'app_service')]
    public function index(): Response
    {
        return $this->render('service/index.html.twig', [
            'controller_name' => '4SE2',
        ]);
    }
    #[Route('/showservice/{nom}', name: 'showservice')]
    public function showservice($nom): Response
    {
        return $this->render('service/showservice.html.twig', [
            'n' => $nom,
        ]);
    }
}
