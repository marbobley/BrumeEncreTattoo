<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class PortfolioController extends AbstractController
{
    #[Route('/portfolio', name: 'app_portfolio')]
    public function index(): Response
    {
        $images = [
            ['src' => 'dosCeci.webp', 'alt' => 'Tatouage dos floral et dentelle'],
            ['src' => 'dosDamien.webp', 'alt' => 'Tatouage dos complet'],
            ['src' => 'piedTulipe.webp', 'alt' => 'Tatouage tulipe sur le pied'],
            ['src' => 'meduse.webp', 'alt' => 'Tatouage méduse'],
            ['src' => 'ninja.webp', 'alt' => 'Tatouage inspiration ninja'],
            ['src' => 'rosePied.webp', 'alt' => 'Tatouage rose sur le pied'],
        ];

        return $this->render('portfolio/index.html.twig', [
            'images' => $images,
        ]);
    }
}
