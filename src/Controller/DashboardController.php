// src/Controller/DashboardController.php
namespace App\Controller;

use App\Entity\User;
use App\Repository\TaskRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;

class DashboardController extends AbstractController
{
    private $taskRepository;
    private $userRepository;

    public function __construct(TaskRepository $taskRepository, UserRepository $userRepository)
    {
        $this->taskRepository = $taskRepository;
        $this->userRepository = $userRepository;
    }

    /**
     * @Route("/dashboard", name="app_dashboard")
     */
    public function index(): Response
    {
        // Récupérer tous les utilisateurs
        $users = $this->userRepository->findAll();

        // Récupérer les statistiques des tâches par utilisateur
        $taskCounts = [];
        $overdueTasks = [];

        foreach ($users as $user) {
            // Récupérer les tâches en cours, terminées et en retard pour chaque utilisateur
            $inProgressTasks = $this->taskRepository->findByStatusAndUser('in_progress', $user);
            $completedTasks = $this->taskRepository->findByStatusAndUser('completed', $user);
            $overdueTasksForUser = $this->taskRepository->findOverdueTasksForUser($user);

            // Ajouter les statistiques dans un tableau
            $taskCounts[$user->getId()] = [
                'in_progress' => count($inProgressTasks),
                'completed' => count($completedTasks),
                'overdue' => count($overdueTasksForUser)
            ];

            // Ajouter les tâches en retard à la liste globale
            $overdueTasks = array_merge($overdueTasks, $overdueTasksForUser);
        }

        return $this->render('dashboard/index.html.twig', [
            'users' => $users,
            'taskCounts' => $taskCounts,
            'overdueTasks' => $overdueTasks
        ]);
    }
}
