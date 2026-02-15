<?php
declare(strict_types=1);

namespace App\Repositories;

use PDO;

/**
 * TaskRepository
 *
 * Responsible for direct DB access for tasks.
 */
class TaskRepository implements TaskRepositoryInterface
{
    /**
     * TaskRepository constructor.
     *
     * @param PDO $pdo The active database connection (injected).
     */
    public function __construct(
        private readonly PDO $pdo
    ) {
    }

    /**
     * Get all tasks ordered by newest first.
     *
     * @return array<int, array<string, mixed>> List of tasks.
     */
    public function getAll(): array
    {
        $stmt = $this->pdo->query('SELECT * FROM tasks ORDER BY created_at DESC');

        return $stmt->fetchAll();
    }

    /**
     * Get a single task by id.
     *
     * @param int $id Task id.
     * @return array<string, mixed>|false Task row or false if not found.
     */
    public function getById(int $id): array|false
    {
        $stmt = $this->pdo->prepare('SELECT * FROM tasks WHERE id = ?');
        $stmt->execute([$id]);

        return $stmt->fetch();
    }

    /**
     * Create a new task.
     *
     * @param string $title Task title.
     * @param string $description Task description.
     * @return int Inserted task id.
     */
    public function create(string $title, string $description = ''): int
    {
        $stmt = $this->pdo->prepare('INSERT INTO tasks (title, description) VALUES (?, ?)');
        $stmt->execute([$title, $description]);

        return (int)$this->pdo->lastInsertId();
    }

    /**
     * Update an existing task.
     *
     * @param int $id Task id.
     * @param string $title Task title.
     * @param string $description Task description.
     * @param string $status Task status ('pending'|'done').
     * @return bool True if update succeeded (row existed), false otherwise.
     */
    public function update(int $id, string $title, string $description, string $status): bool
    {
        $stmt = $this->pdo->prepare('UPDATE tasks SET title = ?, description = ?, status = ? WHERE id = ?');

        return $stmt->execute([$title, $description, $status, $id]);
    }

    /**
     * Delete a task.
     *
     * @param int $id Task id.
     * @return bool True if deletion succeeded, false otherwise.
     */
    public function delete(int $id): bool
    {
        $stmt = $this->pdo->prepare('DELETE FROM tasks WHERE id = ?');

        return $stmt->execute([$id]);
    }
}