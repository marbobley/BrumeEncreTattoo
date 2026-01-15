<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

final class ContactControllerTest extends WebTestCase
{
    public function testContactIsSuccessful(): void
    {
        $client = ContactControllerTest::createClient();
        $client->request('GET', '/contact');

        $this->assertResponseIsSuccessful();
    }

    public function testContactContent(): void
    {
        $client = ContactControllerTest::createClient();
        $crawler = $client->request('GET', '/contact');

        $this->assertSelectorTextContains('h1', 'Prendre rendez-vous');
        $this->assertPageTitleContains('Contact & RDV');

        $this->assertSelectorTextContains('.contact-info', 'Le Studio');
        $this->assertSelectorTextContains('.contact-info', '47 Boulevard Saint-Jean');
        $this->assertSelectorTextContains('.contact-info', '34150 Aniane');
        $this->assertSelectorTextContains('.contact-info', 'contact@brumedencre-tattoo.fr');

        $this->assertSelectorExists('.map-container');

        $this->assertSelectorExists('form[name="contact"]');
        $this->assertSelectorExists('input[name="contact[name]"]');
        $this->assertSelectorExists('input[name="contact[email]"]');
        $this->assertSelectorExists('input[name="contact[subject]"]');
        $this->assertSelectorExists('textarea[name="contact[message]"]');
        $this->assertSelectorExists('input[name="contact[attachment]"]');
        $this->assertSelectorExists('button[type="submit"]');

        $this->assertSelectorTextContains('.useful-info-section', 'Les infos utiles pour ton projet');
        $this->assertCount(5, $crawler->filter('.useful-info-section li'));
    }

    public function testSubmitContactForm(): void
    {
        $client = ContactControllerTest::createClient();
        $crawler = $client->request('GET', '/contact');

        $buttonCrawlerNode = $crawler->selectButton('Envoyer le message');

        $form = $buttonCrawlerNode->form([
            'contact[name]' => 'John Doe',
            'contact[email]' => 'john@example.com',
            'contact[subject]' => 'Projet Tatouage',
            'contact[message]' => 'Bonjour, je souhaite un tatouage floral sur l\'avant-bras.',
        ]);

        $client->submit($form);

        $this->assertResponseRedirects('/contact');
        $client->followRedirect();

        $this->assertSelectorExists('.alert-success');
        $this->assertSelectorTextContains('.alert-success', 'Merci ! Votre message a bien été envoyé.');
    }
}
