<?php

namespace App\Controller\Api;

use App\Repository\TaskRepository;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class TaskApiController
{
    private TaskRepository $taskRepository;

    public function __construct(TaskRepository $taskRepository)
    {
        $this->taskRepository = $taskRepository;
    }

    /**
     * @Route("/api/tasks", name="api_task_list", methods={"GET"})
     */
    public function list(Request $request): JsonResponse
    {
        // Récupérer les paramètres de requête
        $status = $request->query->get('status'); // Filtrer par statut
        $userId = $request->query->get('user');  // Filtrer par utilisateur
        $page = (int) $request->query->get('page', 1); // Pagination (page par défaut : 1)
        $limit = (int) $request->query->get('limit', 10); // Nombre de tâches par page

        // Appel du repository pour obtenir les tâches paginées et filtrées
        $tasks = $this->taskRepository->findPaginatedTasks($status, $userId, $page, $limit);

        // Retourner la réponse en JSON
        return new JsonResponse([
            'page' => $page,
            'limit' => $limit,
            'total' => count($tasks),
            'data' => $tasks
        ]);
    }
}
