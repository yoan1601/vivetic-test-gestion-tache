<?php

// src/Controller/DashboardController.php
namespace App\Controller;

use App\Repository\TaskRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;

class DashboardController extends AbstractController
{
    /**
     * @Route("/dashboard", name="app_dashboard")
     */
    public function index(TaskRepository $taskRepository): Response
    {
        // Exemple de calcul des statistiques des tâches
        $taskCounts = [
            'pending' => $taskRepository->countPendingTasks(),
            'in_progress' => $taskRepository->countInProgressTasks(),
            'completed' => $taskRepository->countCompletedTasks(),
        ];

        // Exemple de récupération des tâches en retard
        $overdueTasks = $taskRepository->findOverdueTasks();

        // Exemple de récupération des utilisateurs et de leurs statistiques
        $users = $this->getDoctrine()->getRepository(User::class)->findAll();

        return $this->render('dashboard/index.html.twig', [
            'taskCounts' => $taskCounts,
            'overdueTasks' => $overdueTasks,
            'users' => $users,
        ]);
    }
}

<?php

namespace App\Controller;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DashboardController extends AbstractController
{
    private EntityManagerInterface $entityManager;

    // Injection de EntityManagerInterface
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    #[Route('/dashboard', name: 'dashboard')]
    public function index(): Response
    {
        // Utilisation de l'EntityManager pour récupérer les utilisateurs
        $users = $this->entityManager->getRepository(User::class)->findAll();

        return $this->render('dashboard/index.html.twig', [
            'users' => $users,
        ]);
    }
}


