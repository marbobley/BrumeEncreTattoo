<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

final class HomeControllerTest extends WebTestCase
{
    public function testIndexIsSuccessful(): void
    {
        $client = HomeControllerTest::createClient();
        $client->request('GET', '/');

        $this->assertResponseIsSuccessful();
    }

    public function testIndexContent(): void
    {
        $client = HomeControllerTest::createClient();
        $crawler = $client->request('GET', '/');

        // Vérification du titre H1
        $this->assertSelectorTextContains('h1', 'Brume d\'Encre Tattoo');

        // Vérification du titre de la page
        $this->assertPageTitleContains('Brume d\'Encre Tattoo');

        // Vérification de la navigation
        $this->assertSelectorExists('nav');
        $this->assertSelectorTextContains('nav', 'Accueil');
        $this->assertSelectorTextContains('nav', 'Galerie');
        $this->assertSelectorTextContains('nav', 'Contact');

        // Vérification de la section Hero
        $this->assertSelectorTextContains('.hero-section h2', 'Bienvenue dans mon univers');
        $this->assertSelectorTextContains('.hero-section', 'Mona');
        $this->assertSelectorExists('.hero-section img.hero-image');
        $this->assertSelectorExists('.hero-section .btn-primary:contains("Contact")');

        // Vérification de la section Portfolio (aperçu)
        $this->assertSelectorTextContains('.portfolio-preview h2', 'Aperçu de mon travail');
        $this->assertCount(3, $crawler->filter('.portfolio-item'));
        $this->assertSelectorExists('.portfolio-preview .btn-outline-primary:contains("Voir toute la galerie")');

        // Vérification du Footer
        $this->assertSelectorExists('footer');
        $this->assertSelectorTextContains('footer', 'Brume d\'Encre Tattoo');
        $this->assertSelectorExists('footer .social-links .fa-instagram');
        $this->assertSelectorExists('footer .social-links .fa-facebook');
    }

    public function testClickOnGalleryLink(): void
    {
        $client = HomeControllerTest::createClient();
        $crawler = $client->request('GET', '/');

        $link = $crawler->selectLink('Voir toute la galerie')->link();
        $client->click($link);

        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('h1', 'Galerie Portfolio');
        $this->assertPageTitleContains('Galerie Tatouages');

        $this->assertSelectorExists('.portfolio-card');
    }

    public function testClickOnContactLink(): void
    {
        $client = HomeControllerTest::createClient();
        $crawler = $client->request('GET', '/');

        $link = $crawler->filter('.hero-section .btn-primary')->link();
        $client->click($link);

        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('h1', 'Prendre rendez-vous');
        $this->assertPageTitleContains('Contact & RDV');

        $this->assertSelectorExists('form[name="contact"]');
    }
}
