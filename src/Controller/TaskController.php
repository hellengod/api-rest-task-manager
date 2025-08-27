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

    public static function get(){
        $conn = Database::connect();
        $stmt = $conn->prepare('SELECT * FROM tasks');
        $stmt->execute();
        $tasks = $stmt->fetchAll(\PDO::FETCH_ASSOC);
        $tasks = json_encode($tasks);
        header('Content-Type: application/json');
        echo $tasks;
    }
}