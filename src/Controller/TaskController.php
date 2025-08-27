<?php

namespace App\Controller;
use App\Storage\Database;
class TaskController
{

    public static function create()
    {
        try {
            $body = file_get_contents('php://input');
            $data = json_decode($body, true);

            if (empty($data['title'])) {
                http_response_code(400);
                echo json_encode(['message' => 'O título é obrigatório']);
                return;
            }

            if (!isset($data['description'])) {
                $data['description'] = null;
            }
            if (!isset($data['is_done'])) {
                $data['is_done'] = 0;
            }

            $conn = Database::connect();
            $stmt = $conn->prepare('INSERT INTO tasks (title, description, is_done) VALUES (:title, :description, :is_done)');
            $stmt->bindParam(':title', $data['title']);
            $stmt->bindParam(':description', $data['description']);
            $stmt->bindParam(':is_done', $data['is_done']);
            $stmt->execute();
            http_response_code(201);
            echo json_encode(['message' => 'Tarefa criada com sucesso!']);
        } catch (\Exception $e) {
            http_response_code(500);
            echo json_encode(['message' => 'Erro interno no servidor']);
            return;
        }
    }

    public static function get()
    {
        try {
            $conn = Database::connect();
            $stmt = $conn->prepare('SELECT * FROM tasks');
            $stmt->execute();
            $tasks = $stmt->fetchAll(\PDO::FETCH_ASSOC);
            $tasks = json_encode($tasks);
            header('Content-Type: application/json');
            echo $tasks;
        } catch (\Exception $e) {
            http_response_code(500);
            echo json_encode(['message' => 'Erro interno no servidor']);
            return;
        }
    }

    public static function getTaskById($id)
    {
        try {
            $conn = Database::connect();
            $stmt = $conn->prepare('SELECT * FROM tasks WHERE id = :id');
            $stmt->bindParam(':id', $id);
            $stmt->execute();
            $task = $stmt->fetch(\PDO::FETCH_ASSOC);

            if ($task === false) {
                http_response_code(404);
                echo json_encode(['message' => 'Não foi possivel buscar uma tarefa com este id']);
                return;
            }

            $task = json_encode($task);
            header('Content-Type: application/json');
            echo $task;
        } catch (\Exception $e) {
            http_response_code(500);
            echo json_encode(['message' => 'Erro interno no servidor']);
            return;
        }
    }

    public static function update($id)
    {
        try {
            $body = file_get_contents('php://input');
            $data = json_decode($body, true);

            if (empty($data['title'])) {
                http_response_code(400);
                echo json_encode(['message' => 'O título é obrigatório']);
                return;
            }

            if (!isset($data['description'])) {
                $data['description'] = null;
            }

            $conn = Database::connect();
            $stmt = $conn->prepare('UPDATE tasks SET title = :title, description = :description WHERE id = :id');
            $stmt->bindParam(':title', $data['title']);
            $stmt->bindParam(':description', $data['description']);
            $stmt->bindParam(':id', $id);
            $stmt->execute();

            if ($stmt->rowCount() === 0) {
                http_response_code(404);
                echo json_encode(['message' => 'Tarefa não encontrada']);
                return;
            }

            http_response_code(200);
            echo json_encode(['message' => 'Tarefa atualizada com sucesso!']);
        } catch (\Exception $e) {
            http_response_code(500);
            echo json_encode(['message' => 'Erro interno no servidor']);
            return;
        }
    }

    public static function delete($id)
    {
        try {
            $conn = Database::connect();
            $stmt = $conn->prepare('DELETE FROM tasks WHERE id = :id');
            $stmt->bindParam(':id', $id);
            $stmt->execute();

            if ($stmt->rowCount() === 0) {
                http_response_code(404);
                echo json_encode(['message' => 'Tarefa não encontrada']);
                return;
            }

            http_response_code(200);
            echo json_encode(['message' => 'Tarefa deletada com sucesso!']);
        } catch (\Exception $e) {
            http_response_code(500);
            echo json_encode(['message' => 'Erro interno no servidor']);
            return;
        }
    }
}