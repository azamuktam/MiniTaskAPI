# Mini Task API (Pure PHP)

A lightweight, RESTful API for managing tasks, built with **Pure PHP 8.1+**. Demonstrates **Layered Architecture** (Controller-Service-Repository) and follows **PSR-4** standards.

## 🚀 Features
- No frameworks: pure PHP.
- Layered architecture: Controllers, Services, Repositories.
- Dockerized LEMP stack: Linux, Nginx, MySQL, PHP.
- Security: public/ folder isolation, PDO, prepared statements.
- Modern PHP: strict typing, PHP 8.1+.

## 📂 Project Structure
mini_task_api/
├── app/            # Core application logic
│   ├── Controllers/
│   ├── Core/
│   ├── Helpers/
│   ├── Models/
│   ├── Repositories/
│   └── Services/
├── public/         # Web root (entry point)
├── routes/         # API route definitions
├── test/           # Unit tests
├── infrastructure/ # Docker & DB config
├── vendor/         # Composer dependencies
├── docker-compose.yml
└── Makefile

## ⚡ Getting Started
1. Clone repo
2. Configure environment: `cp .env.example .env`
3. Build and start Docker, install dependencies: `make setup`
4. API available at `http://localhost:8080`

## 📝 Example Requests
- `GET /tasks` → list all tasks
- `POST /tasks` → create task
- `GET /tasks/{id}` → get task
- `PUT /tasks/{id}` → update task
- `DELETE /tasks/{id}` → delete task

## 💾 Database
- MySQL initialized from `infrastructure/database/init.sql`
- Credentials configurable in `.env`

