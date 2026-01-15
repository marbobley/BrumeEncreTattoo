<?php

declare(strict_types=1);

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class SiteMapController extends AbstractController
{
    #[Route("sitemap.xml", name: 'sitemap', format: 'xml')]
    public function index(): Response
    {
        $urls = [];
        $urls[] = ['loc' => $this->generateUrl('app_home')];
        $urls[] = ['loc' => $this->generateUrl('app_contact')];
        $urls[] = ['loc' => $this->generateUrl('app_portfolio')];

        return $this->render('sitemap/sitemap.xml.twig', [
            'urls' => $urls,
        ]);
    }
}
