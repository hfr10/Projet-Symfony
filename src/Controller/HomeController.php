<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(): Response
    {
        return $this->render('home/index.html.twig');
    }

    #[Route('/qui-sommes-nous', name: 'app_about')]
    public function about(): Response
    {
        return $this->render('pages/about.html.twig');
    }

    #[Route('/mentions-legales', name: 'app_legal')]
    public function legal(): Response
    {
        return $this->render('pages/legal.html.twig');
    }

    #[Route('/cgu', name: 'app_cgu')]
    public function cgu(): Response
    {
        return $this->render('pages/cgu.html.twig');
    }

    #[Route('/politique-confidentialite', name: 'app_privacy')]
    public function privacy(): Response
    {
        return $this->render('pages/privacy.html.twig');
    }
}
