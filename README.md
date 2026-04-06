# Mini Task Management System

A task management application built with Laravel 13 featuring both Web (Blade) and RESTful API interfaces, Sanctum authentication, background job reminders, and role-based access control.

## Features

- **User Authentication** - Registration & login (session-based for web, token-based for API via Sanctum)
- **Task CRUD** - Create, read, update, delete tasks with title, description, status, and due date
- **Role-Based Access** - Admin sees all tasks, regular users see only their own
- **Search & Filter** - Filter tasks by status and due date
- **Background Job** - Scheduled daily job sends email reminders for tasks due tomorrow
- **RESTful API** - Full API with proper JSON responses and HTTP status codes
- **Pagination** - Both web and API responses are paginated

## Setup Instructions

### Prerequisites
- PHP 8.3+
- Composer
- MySQL / SQLite
- Node.js & npm (optional - Tailwind CSS CDN used)

### Installation

```bash
# Clone the repository
git clone <repository-url>
cd task-management

# Install PHP dependencies
composer install

# Copy environment file
cp .env.example .env

# Generate application key
php artisan key:generate

# Configure your database in .env
# DB_CONNECTION=mysql
# DB_HOST=127.0.0.1
# DB_PORT=3306
# DB_DATABASE=task_management
# DB_USERNAME=root
# DB_PASSWORD=

# Run migrations
php artisan migrate

# Seed the database (creates admin & test user with sample tasks)
php artisan db:seed

# Start the development server
php artisan serve
```

### Default Users (after seeding)

| Role  | Email              | Password   |
|-------|--------------------|------------|
| Admin | admin@example.com  | password   |
| User  | user@example.com   | password   |

### Queue Worker (for email reminders)

```bash
# Run the queue worker
php artisan queue:work

# The reminder job is scheduled to run daily at 08:00
# To test the scheduler locally:
php artisan schedule:work
```

## API Endpoints

All API endpoints require a Bearer token (Sanctum). Include header: `Authorization: Bearer {token}`

### Authentication

| Method | Endpoint             | Description              |
|--------|---------------------|--------------------------|
| POST   | `/api/auth/register` | Register a new user      |
| POST   | `/api/auth/login`    | Login and get token      |
| POST   | `/api/auth/logout`   | Logout (revoke token)    |

### Tasks (requires authentication)

| Method | Endpoint            | Description               |
|--------|---------------------|---------------------------|
| GET    | `/api/tasks`        | List tasks (paginated)    |
| POST   | `/api/tasks`        | Create a new task         |
| GET    | `/api/tasks/{id}`   | Get a single task         |
| PUT    | `/api/tasks/{id}`   | Update a task             |
| DELETE | `/api/tasks/{id}`   | Delete a task             |

### Query Parameters (GET /api/tasks)

| Parameter  | Description                              |
|------------|------------------------------------------|
| `status`   | Filter by status: pending, in-progress, completed |
| `due_date` | Filter by due date (YYYY-MM-DD)          |
| `page`     | Page number for pagination               |

### Example API Usage

```bash
# Register
curl -X POST http://localhost:8000/api/auth/register \
  -H "Content-Type: application/json" \
  -d '{"name":"John","email":"john@example.com","password":"password","password_confirmation":"password"}'

# Login
curl -X POST http://localhost:8000/api/auth/login \
  -H "Content-Type: application/json" \
  -d '{"email":"user@example.com","password":"password"}'

# Create task
curl -X POST http://localhost:8000/api/tasks \
  -H "Authorization: Bearer {token}" \
  -H "Content-Type: application/json" \
  -d '{"title":"My Task","status":"pending","due_date":"2026-04-10"}'

# List tasks with filter
curl http://localhost:8000/api/tasks\?status\=pending \
  -H "Authorization: Bearer {token}"
```

## Project Structure

```
app/
├── Http/
│   ├── Controllers/
│   │   ├── Api/
│   │   │   ├── AuthController.php    # API authentication
│   │   │   └── TaskController.php    # API task CRUD
│   │   └── TaskController.php        # Web task CRUD
│   └── Requests/
│       ├── StoreTaskRequest.php       # Create task validation
│       └── UpdateTaskRequest.php      # Update task validation
├── Jobs/
│   └── SendTaskDueReminders.php       # Background reminder job
├── Mail/
│   └── TaskDueReminderMail.php        # Reminder email mailable
└── Models/
    ├── Task.php                       # Task model with scopes
    └── User.php                       # User model with roles
```

## Running Tests

```bash
php artisan test
```
