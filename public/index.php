<?php

require __DIR__ . '/../vendor/autoload.php';
use App\Controller\TaskController;

if($_SERVER['REQUEST_METHOD']=='POST' && $_SERVER['REQUEST_URI']=='/tasks'){
    TaskController::create();
}