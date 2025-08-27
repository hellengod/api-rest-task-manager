<?php
namespace App\Domain;
class TaskManager
{
    private $tasks = [];
    private $nextId = 1;

    public function addTask($title, $description, $status)
    {
        $task = new Task($this->nextId++, $title, $description, $status);
        $this->tasks[$task->getId()] = $task;
        return $task;
    }

    public function getAllTasks()
    {
        return $this->tasks;
    }

    public function getTaskById($id)
    {
        return isset($this->tasks[$id]) ? $this->tasks[$id] : null;
    }

    public function updateTask($id, $title, $description, $status)
    {

        if (isset($this->tasks[$id])) {
            $task = $this->tasks[$id];
            $task->setTitle($title);
            $task->setDescription($description);
            $task->setStatus($status);
            return $task;
        }

        return null;
    }

    public function deleteTask($id)
    {

        if (isset($this->tasks[$id])) {
            unset($this->tasks[$id]);
            return true;
        }
        return false;
    }

}