<?php

// src/Repository/TaskRepository.php
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
    public function findByUser($userId)
    {
        return $this->createQueryBuilder('t')
            ->where('t.assigned_to_id = :userId')
            ->setParameter('userId', $userId)
            ->getQuery()
            ->getResult();
    }
}
