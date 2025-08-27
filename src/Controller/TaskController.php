<?php

namespace App\Controller;
use App\Storage\Database;
class TaskController
{

    public static function create()
    {
        $body = file_get_contents('php://input');
        $data = json_decode($body, true);

        $conn = Database::connect();
        $stmt = $conn->prepare('INSERT INTO tasks (title, description) VALUES (:title, :description)');
        $stmt->bindParam(':title', $data['title']);
        $stmt->bindParam(':description', $data['description']);
        $stmt->execute();
        http_response_code(201);
        echo json_encode(['message' => 'Tarefa criada com sucesso!']);

    }

    public static function get()
    {
        $conn = Database::connect();
        $stmt = $conn->prepare('SELECT * FROM tasks');
        $stmt->execute();
        $tasks = $stmt->fetchAll(\PDO::FETCH_ASSOC);
        $tasks = json_encode($tasks);
        header('Content-Type: application/json');
        echo $tasks;
    }

    public static function getTaskById($id)
    {
        $conn = Database::connect();
        $stmt = $conn->prepare('SELECT * FROM tasks WHERE id = :id');
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        $task = $stmt->fetch(\PDO::FETCH_ASSOC);
        $task = json_encode($task);
        header('Content-Type: application/json');
        echo $task;
    }

    public static function update($id)
    {
        $body = file_get_contents('php://input');
        $data = json_decode($body, true);
        $conn = Database::connect();
        $stmt = $conn->prepare('UPDATE tasks SET title = :title, description = :description WHERE id = :id');
        $stmt->bindParam(':title', $data['title']);
        $stmt->bindParam(':description', $data['description']);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        http_response_code(200);
        echo json_encode(['message' => 'Tarefa atualizada com sucesso!']);
    }

    public static function delete($id){
        $conn = Database::connect();
        $stmt = $conn->prepare('DELETE FROM tasks WHERE id = :id');
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        http_response_code(200);
        echo json_encode(['message' => 'Tarefa deletada com sucesso!']);

    }
}