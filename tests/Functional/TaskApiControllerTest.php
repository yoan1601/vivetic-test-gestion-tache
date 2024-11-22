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

        // Récupérer le contenu de la réponse
        $responseContent = $client->getResponse()->getContent();
        $data = json_decode($responseContent, true);

        // Vérifier que les données existent
        $this->assertIsArray($data, 'The response should be an array.');

        // Vérifier que les champs nécessaires sont présents
        foreach ($data as $task) {
            $this->assertArrayHasKey('id', $task);
            $this->assertArrayHasKey('title', $task);
            $this->assertArrayHasKey('status', $task);
            $this->assertArrayHasKey('startDate', $task);
            $this->assertArrayHasKey('endDate', $task);
        }
    }

    public function testGetTasksPagination(): void
    {
        $client = static::createClient();

        // Effectuer une requête GET avec pagination
        $client->request('GET', '/api/tasks', [
            'page' => 1,
            'limit' => 5
        ]);

        // Vérifier que la réponse est 200
        $this->assertResponseStatusCodeSame(Response::HTTP_OK);

        // Récupérer le contenu de la réponse
        $responseContent = $client->getResponse()->getContent();
        $data = json_decode($responseContent, true);

        // Vérifier que le tableau contient au maximum 5 éléments
        $this->assertLessThanOrEqual(5, count($data));
    }
}
