````markdown
# Mini Task API (Pure PHP)

A lightweight, RESTful Task Management API built with Pure PHP 8.1+.
Designed with clean layered architecture (Controllers → Services → Repositories), following SOLID principles and PSR-4 standards.
Fully Dockerized, tested with PHPUnit, and structured to demonstrate modern PHP best practices for maintainable, testable, and professional code.
## 🚀 Features
- No frameworks: pure PHP.
- Layered architecture: Controllers, Services, Repositories.
- Dockerized LEMP stack: Linux, Nginx, MySQL, PHP.
- Security: public/ folder isolation, PDO, prepared statements.
- Modern PHP: strict typing, PHP 8.1+.

## 📂 Project Structure

```text
mini_task_api/
├─ app/
│  ├─ Controllers/
│  ├─ Core/
│  ├─ Helpers/
│  ├─ Models/
│  ├─ Repositories/
│  └─ Services/
├─ public/
├─ routes/
├─ tests/
├─ infrastructure/
├─ vendor/
├─ docker-compose.yml
└─ Makefile
````

## ⚡ Getting Started

1. Clone the repository:

   ```bash
   git clone <repo-url>
   ```
2. Configure environment:

   ```bash
   cp .env.example .env
   ```
3. Build and start Docker, install dependencies:

   ```bash
   make setup
   ```
4. (Optional) Seed demo data:

```bash
make seed
```

5API available at `http://localhost:8080`

## 📝 Example Requests

* `GET /tasks` → list all tasks
* `POST /tasks` → create a task
* `GET /tasks/{id}` → get a specific task
* `PUT /tasks/{id}` → update a task
* `DELETE /tasks/{id}` → delete a task

## 💾 Database

* MySQL initialized from `infrastructure/database/init.sql`
* Credentials configurable in `.env`

