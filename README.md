# Task Manager Application

A simple and elegant task management application built with Laravel that allows users to manage their personal to-do lists with authentication and authorization.

## Features

- **User Authentication**
  - User registration with email and password
  - Secure login with "Remember Me" option
  - Password reset functionality via email
  - Session management and logout

- **Task Management**
  - Create tasks with title and optional description
  - View all personal tasks in a clean list
  - Edit and update existing tasks
  - Delete tasks with confirmation
  - Mark tasks as complete/incomplete with visual indicators
  - View task creation timestamps

- **Security & Authorization**
  - Users can only view, edit, and delete their own tasks
  - Policy-based authorization ensures data privacy
  - CSRF protection on all forms
  - Secure password hashing

## Technology Stack

- **Framework**: Laravel 11.x
- **PHP**: 8.4
- **Database**: MySQL
- **Frontend**: Blade Templates with Tailwind CSS
- **Authentication**: Laravel's built-in authentication

## Installation

### Prerequisites

- PHP 8.4 or higher
- Composer
- MySQL
- Node.js & NPM (optional, for asset compilation)

### Setup Instructions

1. **Clone the repository**
   ```bash
   git clone <your-repository-url>
   cd tasks
   ```

2. **Install dependencies**
   ```bash
   composer install
   ```

3. **Environment configuration**
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

4. **Configure database**
   
   Edit `.env` file and set your database credentials:
   ```env
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=tasks
   DB_USERNAME=root
   DB_PASSWORD=your_password
   ```

5. **Run migrations**
   ```bash
   php artisan migrate
   ```

6. **Configure email (optional)**
   
   For password reset functionality, configure your email settings in `.env`:
   
   **For development (logs emails to file):**
   ```env
   MAIL_MAILER=log
   ```
   
   **For production (example with Gmail):**
   ```env
   MAIL_MAILER=smtp
   MAIL_HOST=smtp.gmail.com
   MAIL_PORT=587
   MAIL_USERNAME=your-email@gmail.com
   MAIL_PASSWORD=your-app-password
   MAIL_ENCRYPTION=tls
   MAIL_FROM_ADDRESS=your-email@gmail.com
   MAIL_FROM_NAME="${APP_NAME}"
   ```

7. **Start the development server**
   ```bash
   php artisan serve
   ```

8. **Access the application**
   
   Open your browser and navigate to `http://localhost:8000`

## Usage

1. **Register a new account** at `/register`
2. **Login** with your credentials at `/login`
3. **Create tasks** by clicking "Create New Task"
4. **Manage your tasks** from the main dashboard:
   - Click the checkbox to mark tasks as complete/incomplete
   - Click "Edit" to modify a task
   - Click "Delete" to remove a task
5. **Logout** when finished

## Project Structure

```
├── app/
│   ├── Http/Controllers/
│   │   ├── Auth/              # Authentication controllers
│   │   └── TaskController.php # Task CRUD operations
│   ├── Models/
│   │   ├── Task.php           # Task model
│   │   └── User.php           # User model
│   └── Policies/
│       └── TaskPolicy.php     # Task authorization policy
├── database/
│   └── migrations/            # Database migrations
├── resources/
│   └── views/
│       ├── auth/              # Authentication views
│       ├── layouts/           # Layout templates
│       └── tasks/             # Task management views
└── routes/
    └── web.php                # Application routes
```

## Database Schema

### Users Table
- id
- name
- email (unique)
- password
- remember_token
- timestamps

### Tasks Table
- id
- user_id (foreign key)
- title
- description (nullable)
- is_completed (boolean, default: false)
- timestamps

## Routes

### Authentication Routes
- `GET /login` - Login form
- `POST /login` - Process login
- `POST /logout` - Logout user
- `GET /register` - Registration form
- `POST /register` - Process registration
- `GET /forgot-password` - Password reset request form
- `POST /forgot-password` - Send reset link
- `GET /reset-password/{token}` - Password reset form
- `POST /reset-password` - Process password reset

### Task Routes (Authenticated)
- `GET /tasks` - List all user tasks
- `GET /tasks/create` - Create task form
- `POST /tasks` - Store new task
- `GET /tasks/{task}/edit` - Edit task form
- `PUT /tasks/{task}` - Update task
- `DELETE /tasks/{task}` - Delete task
- `POST /tasks/{task}/toggle` - Toggle task completion

## Security Features

- Password hashing with bcrypt
- CSRF token protection
- SQL injection prevention via Eloquent ORM
- Authorization policies prevent unauthorized access
- Session regeneration on login
- Secure password reset tokens

## License

This project is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
