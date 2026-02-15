<?php
declare(strict_types=1);

namespace App\Controllers;

use App\Services\TaskService;
use App\Helpers\Response;

/**
 * TaskController
 *
 * Thin controller that converts HTTP requests to service calls.
 */
class TaskController
{
    /**
     * TaskController constructor.
     */
    public function __construct(private readonly TaskService $service)
    {
    }

    /**
     * GET /tasks
     *
     * @return void
     */
    public function index(): void
    {
        $tasks = $this->service->getAll();
        Response::json($tasks);
    }

    /**
     * GET /tasks/{id}
     *
     * @param int $id
     * @return void
     */
    public function show(int $id): void
    {
        $task = $this->service->getById($id);
        Response::json($task);
    }

    /**
     * POST /tasks
     *
     * @return void
     */
    public function add(): void
    {
        $data = json_decode((string)file_get_contents('php://input'), true) ?: [];
        $id = $this->service->create($data);
        Response::json(['message' => 'Task created', 'id' => $id], 201);
    }

    /**
     * PUT /tasks/{id}
     *
     * @param int $id
     * @return void
     */
    public function update(int $id): void
    {
        $data = json_decode((string)file_get_contents('php://input'), true) ?: [];
        $this->service->update($id, $data);
        Response::json(['message' => 'Task updated']);
    }

    /**
     * DELETE /tasks/{id}
     *
     * @param int $id
     * @return void
     */
    public function delete(int $id): void
    {
        $this->service->delete($id);
        Response::json(['message' => 'Task deleted']);
    }
}
