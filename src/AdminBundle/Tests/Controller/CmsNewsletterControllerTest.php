<?php

namespace AdminBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class CmsNewsletterControllerTest extends WebTestCase
{
    public function testExport()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/export');
    }

}
