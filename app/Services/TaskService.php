<?php
declare(strict_types=1);

namespace App\Services;

use App\Helpers\Validator;
use App\Repositories\TaskRepository;
use App\Helpers\Response;
use App\Core\Database;
use App\Repositories\TaskRepositoryInterface;

/**
 * TaskService
 *
 * Encapsulates business logic and validation for tasks.
 */
class TaskService
{
    /**
     * TaskService constructor.
     * * Manually injects the Database connection into the Repository.
     */
    public function __construct(
        private TaskRepositoryInterface $repository
    ) {}


    /**
     * Return all tasks.
     *
     * @return array<int, array<string, mixed>>
     */
    public function getAll(): array
    {
        return $this->repository->getAll();
    }

    /**
     * Return a single task or error out.
     *
     * @param int $id Task id.
     * @return array<string, mixed>
     */
    public function getById(int $id): array
    {
        $task = $this->repository->getById($id);
        if ($task === false) {
            Response::error('Task not found', 404);
        }

        return $task;
    }

    /**
     * Create task after validating payload.
     *
     * @param array<string, mixed> $data Input data (expects 'title' and optional 'description').
     * @return int Created task id.
     */
    public function create(array $data): int
    {
        Validator::validate($data, [
            'title'       => 'required|min:3',
            'description' => 'min:10'
        ]);

        return $this->repository->create(
            trim((string)$data['title']),
            trim((string)($data['description'] ?? ''))
        );
    }

    /**
     * Update a task after validating payload.
     *
     * @param int $id Task id.
     * @param array<string, mixed> $data Input data (expects 'title' and 'status' at minimum).
     * @return void
     */
    public function update(int $id, array $data): void
    {
        $this->getById($id);

        Validator::validate($data, [
            'title'  => 'required|min:3',
            'status' => 'required|in:pending,done'
        ]);

        $this->repository->update(
            $id,
            trim((string)$data['title']),
            trim((string)($data['description'] ?? '')),
            $data['status']
        );
    }

    /**
     * Delete a task.
     *
     * @param int $id Task id.
     * @return void
     */
    public function delete(int $id): void
    {
        $ok = $this->repository->delete($id);
        if (!$ok) {
            Response::error('Task not found', 404);
        }
    }
}