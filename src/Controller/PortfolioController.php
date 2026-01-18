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
            ['src' => 'dosCeci.webp', 'alt' => 'Tatouage dos floral et dentelle', 'width' => 800, 'height' => 1067],
            ['src' => 'dosDamien.webp', 'alt' => 'Tatouage dos complet', 'width' => 800, 'height' => 1067],
            ['src' => 'piedTulipe.webp', 'alt' => 'Tatouage tulipe sur le pied', 'width' => 800, 'height' => 1127],
            ['src' => 'meduse.webp', 'alt' => 'Tatouage méduse', 'width' => 800, 'height' => 1107],
            ['src' => 'ninja.webp', 'alt' => 'Tatouage inspiration ninja', 'width' => 800, 'height' => 1432],
            ['src' => 'rosePied.webp', 'alt' => 'Tatouage rose sur le pied', 'width' => 800, 'height' => 1045],
            ['src' => 'textTattoo.webp', 'alt' => 'Tatouage texte sur l epaule', 'width' => 800, 'height' => 600],
            ['src' => 'jambaquarelle.webp', 'alt' => 'Tatouage aquarelle sur la jambe', 'width' => 800, 'height' => 1181],
            ['src' => 'chouette.webp', 'alt' => 'Tatouage aquarelle sur la jambe', 'width' => 800, 'height' => 1216],
            ['src' => 'avant_bras_floral.webp', 'alt' => 'Tatouage floral sur l avant bras', 'width' => 800, 'height' => 800],
            ['src' => 'coude.webp', 'alt' => 'Tatouage psyché sur le coude et floral', 'width' => 800, 'height' => 900],
            ['src' => 'jambe.webp', 'alt' => 'Dotwork sur la jambe', 'width' => 800, 'height' => 1388],
        ];

        return $this->render('portfolio/index.html.twig', [
            'images' => $images,
        ]);
    }
}
