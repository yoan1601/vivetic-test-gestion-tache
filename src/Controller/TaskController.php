<?php

// src/Controller/TaskController.php
namespace App\Controller;

use App\Entity\Task;
use App\Form\TaskType;
use App\Repository\TaskRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TaskController extends AbstractController
{
    /**
     * @Route("/tasks", name="task_index")
     */
    public function index(TaskRepository $taskRepository)
    {
        $tasks = $this->getUser()->getRoles() === ['ROLE_ADMIN']
            ? $taskRepository->findAll() // Admin can see all tasks
            : $taskRepository->findByUser($this->getUser()->getId()); // User sees only their tasks

        return $this->render('task/index.html.twig', [
            'tasks' => $tasks,
        ]);
    }

    /**
     * @Route("/tasks/create", name="task_create")
     */
    public function create(Request $request)
    {
        $task = new Task();
        $form = $this->createForm(TaskType::class, $task);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $task = $form->getData();
            $task->setAssignedTo($this->getUser());
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($task);
            $entityManager->flush();

            $this->addFlash('success', 'Task created successfully!');

            return $this->redirectToRoute('task_index');
        }

        return $this->render('task/create.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/tasks/{id}/edit", name="task_edit")
     */
    public function edit(Request $request, Task $task)
    {
        $form = $this->createForm(TaskType::class, $task);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();
            $this->addFlash('success', 'Task updated successfully!');
            return $this->redirectToRoute('task_index');
        }

        return $this->render('task/edit.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/tasks/{id}/delete", name="task_delete")
     */
    public function delete(Task $task)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($task);
        $entityManager->flush();

        $this->addFlash('success', 'Task deleted successfully!');
        return $this->redirectToRoute('task_index');
    }

}
