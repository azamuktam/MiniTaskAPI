<?php
declare(strict_types=1);

namespace App\Models;

/**
 * Task Model
 *
 * Represents a single Task entity.
 */
class Task
{
    /** @var int The unique ID of the task */
    public int $id;

    /** @var string The title of the task */
    public string $title;

    /** @var string The description of the task */
    public string $description;

    /** @var string The status of the task ('pending' or 'done') */
    public string $status;

    /** @var string The creation timestamp */
    public string $createdAt;

    /**
     * Task constructor.
     *
     * @param array<string, mixed> $data Associative array of task data.
     */
    public function __construct(array $data)
    {
        $this->id          = (int)($data['id'] ?? 0);
        $this->title       = (string)($data['title'] ?? '');
        $this->description = (string)($data['description'] ?? '');
        $this->status      = (string)($data['status'] ?? 'pending');
        $this->createdAt   = (string)($data['created_at'] ?? '');
    }

    /**
     * Convert the object properties to an associative array.
     *
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        return [
            'id'          => $this->id,
            'title'       => $this->title,
            'description' => $this->description,
            'status'      => $this->status,
            'created_at'  => $this->createdAt,
        ];
    }
}