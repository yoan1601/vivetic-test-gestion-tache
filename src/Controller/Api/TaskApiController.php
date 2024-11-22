<?php

namespace App\Controller\Api;

use App\Repository\TaskRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Routing\Annotation\Route;

class TaskApiController extends AbstractController
{
    /**
     * @Route("/api/tasks", name="api_task_list", methods={"GET"})
     */
    public function list(Request $request, TaskRepository $taskRepository, SerializerInterface $serializer): JsonResponse
    {
        // Pagination & Filtres
        $status = $request->query->get('status');
        $userId = $request->query->get('user');
        $page = max((int)$request->query->get('page', 1), 1);
        $limit = 10;

        $tasks = $taskRepository->findPaginatedTasks($status, $userId, $page, $limit);

        // Utiliser le serializer pour convertir les données en JSON
        $data = $serializer->serialize($tasks, 'json', ['groups' => 'task:read']);

        return new JsonResponse($data, 200, [], true);
    }
}
 