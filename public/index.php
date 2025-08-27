<?php

require __DIR__ . '/../vendor/autoload.php';
use App\Controller\TaskController;

if ($_SERVER['REQUEST_METHOD'] == 'POST' && $_SERVER['REQUEST_URI'] == '/tasks') {
    TaskController::create();
} else if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    $parts = explode('/', $_SERVER['REQUEST_URI']);

    if ($parts[1] === 'tasks' && !isset($parts[2])) {
        TaskController::get();
    } elseif ($parts[1] === 'tasks' && isset($parts[2])) {
        $id = $parts[2];
        TaskController::getTaskById($id);
    }
} else if ($_SERVER['REQUEST_METHOD'] == 'PUT') {
    $parts = explode('/', $_SERVER['REQUEST_URI']);
    if ($parts[1] === 'tasks' && isset($parts[2])) {
        $id = $parts[2];
        TaskController::update($id);
    }
} else if ($_SERVER['REQUEST_METHOD'] == 'DELETE') {
    $parts = explode('/', $_SERVER['REQUEST_URI']);
    if ($parts[1] === 'tasks' && isset($parts[2])) {
        $id = $parts[2];
        TaskController::delete($id);
    }
}
