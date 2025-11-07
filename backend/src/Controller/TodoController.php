<?php

namespace App\Controller;

use App\Services\TodoService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;

final class TodoController extends AbstractController
{

    /**
     * @var EntityManagerInterface
     */
    public $em;

    /**
     * @var TodoService
     */
    public $todoService;

    public function __construct(EntityManagerInterface $em, TodoService $todoService)
    {
        $this->em = $em;
        $this->todoService = $todoService;
    }

    #[Route('/api/list', name: 'todo_list')]
    public function listAction(): JsonResponse
    {
        return $this->json($this->todoService->getTodoList());
    }

    #[Route('/api/new', name: 'app_todo_new', methods: ['POST'])]
    public function new(): JsonResponse
    {
        $this->em->beginTransaction();

        try{
            $this->todoService->add("Example 1");
            $this->em->commit();
        }catch(\Exception $ex){
            $this->em->rollback();
            return $this->json($ex->getMessage());
        }

        return $this->json([]);
    }


}
