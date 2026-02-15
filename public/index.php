<?php
/**
 * Application Entry Point
 */
declare(strict_types=1);

require_once __DIR__ . '/../vendor/autoload.php';

use App\Core\Router;
use App\Core\Database;
use App\Repositories\TaskRepository;
use App\Services\TaskService;
use App\Controllers\TaskController;
use Dotenv\Dotenv;

// 1. Load Env
$dotenv = Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();

// 2. Initialize Router
$router = new Router();

// 3. DEPENDENCY INJECTION
// A. Database
$pdo = Database::getConnection();

// B. Repository (Inject PDO)
$repository = new TaskRepository($pdo);

// C. Service (Inject Repository)
$service = new TaskService($repository);

// D. Controller (Inject Service)
$taskController = new TaskController($service);

// 4. Load Routes
require_once __DIR__ . '/../routes/api.php';

// 5. Dispatch
$router->dispatch($_SERVER['REQUEST_URI'], $_SERVER['REQUEST_METHOD']);