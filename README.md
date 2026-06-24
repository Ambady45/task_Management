<<<<<<< HEAD
# Task Management System

A Laravel-based Task Management System with authentication, role-based access control, task assignment, and task archiving functionality.

## Tech Stack

* Framework: Laravel
* Database: MySQL
* Frontend: Blade / Laravel UI 
* Authentication: Laravel Authentication
* Authorization: Roles, Policies, and Gates

---
# Installation Guide

## Clone Repository

```bash
git clone <repository-url>
```

Navigate into the project:

```bash
cd task-management-system
```

---

## Install Dependencies

Install PHP dependencies:

```bash
composer install
```

Install frontend dependencies:

```bash
npm install
```

---

## Environment Setup

Copy environment file:

```bash
cp .env.example .env
```

Generate application key:

```bash
php artisan key:generate
```

---

## Database Configuration

Update `.env` file:

```
DB_DATABASE=task_management
DB_USERNAME=
DB_PASSWORD=
```

Create database in MySQL and run:

```bash
php artisan migrate --seed
```

---

## Run Application

Start Laravel server:

```bash
php artisan serve
```

For frontend assets:

```bash
npm run dev
```

Application will be available at:

```
http://127.0.0.1:8000
```

---

# Sample Roles

Example users:

Admin:

```
admin@test.com
```

Head:

```
head@test.com
```

User:

```
user@test.com
```

(Password details can be found in seeders)

---
## Features

### Authentication

* User registration and login
* Secure authentication system
* Role-based access control

### User Roles

The system supports three roles:

### Admin

* Full access to the system
* Can view and manage all tasks
* Can manage users and permissions

### Head

* Can create tasks
* Can assign tasks to multiple users
* Can remove users from tasks
* Can update status of tasks they created
* Can view all created tasks

### User

* Can create tasks for themselves
* Can view assigned tasks
* Can update status of tasks assigned to them
* Can manage their own created tasks

---

# Task Management

Each task contains:

* Title
* Description 
* Status
* Due Date
* Owner
* Assigned Users

Supported task statuses:

* Pending
* In Progress
* Completed

---

# Task Assignment

The application supports many-to-many relationships between users and tasks.

A task can have multiple assigned users and a user can have multiple tasks.

Responsibilities:

* Owner:

  * User who created the task
  * Has full control over task changes

* Contributors:

  * Other assigned users
  * Can update task status based on permissions

---

# Authorization

Access control is handled using:

* Laravel Policies
* Role-based authorization

Rules implemented:

* Users can only access tasks assigned to them
* Admin and Head users have elevated permissions
* Only task owners can change due dates
* Only owners can archive tasks

---

# Business Rules

Implemented rules:

* A task cannot be marked completed before the due date unless updated by an elevated user
* Tasks with multiple assigned users cannot be permanently deleted
* Only task owners can update due dates
* Archived tasks are hidden from default listings

---

# Task Archiving

Tasks use soft delete functionality.

Features:

* Archive tasks instead of permanent deletion
* Restore archived tasks
* Archived tasks are excluded from normal task views

---

# Database Design

Main tables:

### Users

Stores user information and roles.

### Tasks

Stores task details:

* title
* description
* status
* due_date
* owner_id

### Task_User

Pivot table for many-to-many relationship:

* task_id
* user_id

This table connects users and tasks.

---



# Project Structure

```
app
 ├── Models
 │    ├── User.php
 │    └── Task.php
 │
 ├── Policies
 │    └── TaskPolicy.php
 │
 ├── Http
 │    └── Controllers
 │
database
 ├── migrations
 └── seeders

resources
 └── views
```

---

# Design Explanation

The many-to-many relationship between users and tasks is implemented using a pivot table (`task_user`). This allows multiple users to be assigned to multiple tasks.

Authorization is handled using Laravel Policies and role checks to ensure users only access permitted tasks.

Business rules such as due date restrictions and deletion limitations are placed inside models/policies to maintain clean separation of logic.

If given more time, improvements would include adding notifications, activity logs, advanced filtering, and API support.

---

# License

This project is developed for evaluation purposes.
=======
# task_Management
>>>>>>> 467c8d731bbd35ed838bf59b0da3938626325f87
