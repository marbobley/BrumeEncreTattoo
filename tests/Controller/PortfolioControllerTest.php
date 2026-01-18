<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

final class PortfolioControllerTest extends WebTestCase
{
    public function testPortfolioIsSuccessful(): void
    {
        $client = PortfolioControllerTest::createClient();
        $client->request('GET', '/portfolio');

        $this->assertResponseIsSuccessful();
    }

    public function testPortfolioContent(): void
    {
        $client = PortfolioControllerTest::createClient();
        $crawler = $client->request('GET', '/portfolio');

        // Vérification des titres
        $this->assertSelectorTextContains('h1', 'Galerie Portfolio');
        $this->assertPageTitleContains('Galerie Tatouages : Fine line, Floral et Dentelle');

        $this->assertCount(12, $crawler->filter('.portfolio-card'));

        $this->assertSelectorExists('.portfolio-card img');

        $this->assertSelectorExists('a.btn-primary:contains("Discutons de ton projet")');
        $this->assertSelectorTextContains('p.lead', 'Chaque pièce est unique et réalisée sur mesure.');
    }
}
