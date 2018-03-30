<?php

namespace RsBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class RsReservationControllerTest extends WebTestCase
{
    public function testCalendar()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/calendar');
    }

}
