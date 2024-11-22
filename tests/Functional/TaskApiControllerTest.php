<?php

namespace App\Tests\Functional;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

class TaskApiControllerTest extends WebTestCase
{
    public function testGetTasksList(): void
    {
        $client = static::createClient();

        // Effectuer une requête GET sur l'API
        $client->request('GET', '/api/tasks', [
            'status' => 'pending',
            'page' => 1,
            'user' => 2
        ]);

        // Vérifier que la réponse a un code 302
        $this->assertResponseStatusCodeSame(302);

        // Récupérer le contenu de la réponse
        $responseContent = $client->getResponse()->getContent();
        $data = json_decode($responseContent, true);

        // Vérifier que les données existent
        $this->assertNull($data, 'The response should be null. Due to security');
    }
}
