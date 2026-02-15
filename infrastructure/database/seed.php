<?php
declare(strict_types=1);

require __DIR__ . '/../../vendor/autoload.php';

use App\Core\Database;
use Dotenv\Dotenv;

// 1. Load Env (important for DB credentials)
if (file_exists(__DIR__ . '/../.env')) {
    $dotenv = Dotenv::createImmutable(__DIR__ . '/../');
    $dotenv->load();
}

try {
    // 2. Get PDO connection
    $pdo = Database::getConnection();

    echo "🌱 Seeding database...\n";

    // 3. Clear existing data to avoid primary key conflicts
    $pdo->exec("SET FOREIGN_KEY_CHECKS = 0;");
    $pdo->exec("TRUNCATE TABLE tasks;");
    $pdo->exec("SET FOREIGN_KEY_CHECKS = 1;");

    // 4. Sample tasks
    $tasks = [
        ['title' => 'Design API Structure', 'status' => 'done', 'description' => 'Create the initial layered architecture.'],
        ['title' => 'Implement Unit Tests', 'status' => 'pending', 'description' => 'Write tests for the TaskService.'],
        ['title' => 'Setup Docker environment', 'status' => 'done', 'description' => 'Configure Nginx and MySQL.'],
        ['title' => 'Push to GitHub', 'status' => 'pending', 'description' => 'Complete the README and push code.'],
    ];

    // 5. Insert tasks
    $stmt = $pdo->prepare("INSERT INTO tasks (title, status, description) VALUES (:title, :status, :description)");

    foreach ($tasks as $task) {
        $stmt->execute($task);
        echo "Inserted: {$task['title']}\n";
    }

    echo "Database seeded successfully.\n";

} catch (\Exception $e) {
    echo "Seeding failed: " . $e->getMessage() . "\n";
    exit(1);
}