<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

final class SiteMapControllerTest extends WebTestCase
{
    public function testSitemapIsSuccessful(): void
    {
        $client = static::createClient();
        $client->request('GET', '/sitemap.xml');

        $this->assertResponseIsSuccessful();
        $this->assertResponseHeaderSame('Content-Type', 'application/xml');
    }

    public function testSitemapContent(): void
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/sitemap.xml');

        $content = $client->getResponse()->getContent();
        $this->assertStringContainsString('<loc>http://localhost/</loc>', $content);
        $this->assertStringContainsString('<changefreq>monthly</changefreq>', $content);
        $this->assertStringContainsString('<priority>1.0</priority>', $content);

        $this->assertStringContainsString('<loc>http://localhost/portfolio</loc>', $content);
        $this->assertStringContainsString('<priority>0.8</priority>', $content);

        $this->assertStringContainsString('<loc>http://localhost/contact</loc>', $content);
        $this->assertStringContainsString('<changefreq>yearly</changefreq>', $content);
        $this->assertStringContainsString('<priority>0.5</priority>', $content);

        $lastmod = (new \DateTime())->format('Y-m-d');
        $this->assertStringContainsString('<lastmod>' . $lastmod . '</lastmod>', $content);
    }
}
