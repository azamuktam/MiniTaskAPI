<?php
declare(strict_types=1);

namespace App\Repositories;

/**
 * TaskRepositoryInterface
 *
 * Defines the contract for any data storage implementation (MySQL, Redis, etc.)
 * that handles Task entities.
 */
interface TaskRepositoryInterface
{
    /**
     * Retrieve all tasks from storage.
     *
     * @return array<int, array<string, mixed>> List of tasks.
     */
    public function getAll(): array;

    /**
     * Retrieve a single task by its ID.
     *
     * @param int $id The unique ID of the task.
     * @return array<string, mixed>|false The task data or false if not found.
     */
    public function getById(int $id): array|false;

    /**
     * Create a new task.
     *
     * @param string $title       The title of the task.
     * @param string $description The optional description.
     * @return int The ID of the newly created task.
     */
    public function create(string $title, string $description = ''): int;

    /**
     * Update an existing task.
     *
     * @param int    $id          The ID of the task to update.
     * @param string $title       The new title.
     * @param string $description The new description.
     * @param string $status      The new status ('pending'|'done').
     * @return bool True if the task was found and updated, false otherwise.
     */
    public function update(int $id, string $title, string $description, string $status): bool;

    /**
     * Delete a task by its ID.
     *
     * @param int $id The ID of the task to delete.
     * @return bool True if the task was found and deleted, false otherwise.
     */
    public function delete(int $id): bool;
}