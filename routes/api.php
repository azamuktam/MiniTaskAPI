<?php
/** @var \App\Core\Router $router */
/** @var \App\Controllers\TaskController $taskController */

$router->get('/tasks',       [$taskController, 'index']);
$router->get('/tasks/{id}',  [$taskController, 'show']);
$router->post('/tasks',      [$taskController, 'add']);
$router->put('/tasks/{id}',  [$taskController, 'update']);
$router->delete('/tasks/{id}', [$taskController, 'delete']);