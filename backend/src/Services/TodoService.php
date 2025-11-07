<?php

namespace App\Services;

use App\Entity\TodoList;
use App\Repository\TodoListRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;

class TodoService{

    /**
     * @var EntityManager
     */
    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }


    public function getTodoList(){
        $list = [];

        $todoList = $this->em->getRepository(TodoList::class)->findAll();

        foreach ($todoList as $res) {
            $list[] = [
                'id' => $res->getId(),
                'name' => $res->getName()
            ];
        }

        return $list;
    }

    public function add($name = "Todo Example"){
        $todo = new TodoList();
        $todo->setName($name);

        $this->em->persist($todo);
        $this->em->flush();
    }
}