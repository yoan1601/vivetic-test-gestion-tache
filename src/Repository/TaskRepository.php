<?php

// src/Repository/TaskRepository.php
namespace App\Repository;

use App\Entity\Task;
use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class TaskRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Task::class);
    }

    // Exemple de méthode pour récupérer les tâches par statut
    public function findByStatus($status)
    {
        return $this->createQueryBuilder('t')
            ->where('t.status = :status')
            ->setParameter('status', $status)
            ->getQuery()
            ->getResult();
    }

    // Exemple de méthode pour récupérer les tâches d'un utilisateur
    public function findByUser($user)
    {
        return $this->createQueryBuilder('t')
            ->where('t.assignedTo = :user')
            ->setParameter('user', $user)
            ->getQuery()
            ->getResult();
    }

    // Exemple de méthode pour compter les tâches en attente
    public function countPendingTasks(): int
    {
        return $this->createQueryBuilder('t')
            ->select('COUNT(t.id)')
            ->where('t.status = :status')
            ->setParameter('status', 'pending')
            ->getQuery()
            ->getSingleScalarResult();
    }

    // Exemple de méthode pour compter les tâches en cours
    public function countInProgressTasks(): int
    {
        return $this->createQueryBuilder('t')
            ->select('COUNT(t.id)')
            ->where('t.status = :status')
            ->setParameter('status', 'in_progress')
            ->getQuery()
            ->getSingleScalarResult();
    }

    // Exemple de méthode pour compter les tâches terminées
    public function countCompletedTasks(): int
    {
        return $this->createQueryBuilder('t')
            ->select('COUNT(t.id)')
            ->where('t.status = :status')
            ->setParameter('status', 'completed')
            ->getQuery()
            ->getSingleScalarResult();
    }

    // Exemple de méthode pour récupérer les tâches en retard
    public function findOverdueTasks(): array
    {
        return $this->createQueryBuilder('t')
            ->where('t.endDate < :now AND t.status != :completed')
            ->setParameter('now', new \DateTime())
            ->setParameter('completed', 'completed')
            ->getQuery()
            ->getResult();
    }

    // Récupérer les tâches par statut et utilisateur
    public function findByStatusAndUser(string $status, User $user)
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.status = :status')
            ->andWhere('t.assignedTo = :user')
            ->setParameter('status', $status)
            ->setParameter('user', $user)
            ->getQuery()
            ->getResult();
    }

    // Récupérer les tâches en retard pour un utilisateur
    public function findOverdueTasksForUser(User $user)
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.assignedTo = :user')
            ->andWhere('t.endDate < :now')
            ->setParameter('user', $user)
            ->setParameter('now', new \DateTime())
            ->getQuery()
            ->getResult();
    }
}

<?php

namespace App\Repository;

use App\Entity\Task;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class TaskRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Task::class);
    }

    public function findPaginatedTasks(?string $status, ?int $userId, int $page, int $limit): array
    {
        $queryBuilder = $this->createQueryBuilder('t');

        // Appliquer un filtre par statut
        if ($status) {
            $queryBuilder->andWhere('t.status = :status')
                ->setParameter('status', $status);
        }

        // Appliquer un filtre par utilisateur
        if ($userId) {
            $queryBuilder->andWhere('t.assignedTo = :userId')
                ->setParameter('userId', $userId);
        }

        // Pagination
        $queryBuilder->setFirstResult(($page - 1) * $limit)
            ->setMaxResults($limit);

        // Ordre par date de création (exemple)
        $queryBuilder->orderBy('t.createdAt', 'DESC');

        return $queryBuilder->getQuery()->getResult();
    }
}
