<?php

require __DIR__ . '/../vendor/autoload.php';
use App\Controller\TaskController;

if ($_SERVER['REQUEST_METHOD'] == 'POST' && $_SERVER['REQUEST_URI'] == '/tasks') {
    TaskController::create();
} else if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    $path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
    $parts = explode('/', $path);
    if ($parts[1] === 'tasks' && !isset($parts[2])) {
        TaskController::get();
    } elseif ($parts[1] === 'tasks' && isset($parts[2])) {
        $id = $parts[2];
        TaskController::getTaskById($id);
    }
} else if ($_SERVER['REQUEST_METHOD'] == 'PUT') {
    $path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
    $parts = explode('/', $path);
    if ($parts[1] === 'tasks' && isset($parts[2])) {
        $id = $parts[2];
        TaskController::update($id);
    }
} else if ($_SERVER['REQUEST_METHOD'] == 'DELETE') {
    $path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
    $parts = explode('/', $path);
    if ($parts[1] === 'tasks' && isset($parts[2])) {
        $id = $parts[2];
        TaskController::delete($id);
    }
} else if ($_SERVER['REQUEST_METHOD'] == 'PATCH') {
    $path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
    $parts = explode('/', $path);
    if ($parts[1] === 'tasks' && isset($parts[2], $parts[3]) && $parts[3] === 'done') {
        $id = $parts[2];
        TaskController::markAsDone($id);
    } else if ($parts[1] === 'tasks' && isset($parts[2], $parts[3]) && $parts[3] === 'undone') {
        $id = $parts[2];
        TaskController::markAsUndone($id);
    }
} else {
    http_response_code(404);
    header('Content-Type: application/json');
    echo json_encode(['message' => 'Rota não encontrada']);
}

