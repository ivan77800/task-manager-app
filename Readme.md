# Task Management System

A full-stack task management application built with **Laravel 13** (backend API) and **Next.js 14** (frontend) with Docker support.

## Live URLs (After Setup)

- **Frontend**: http://localhost:3000
- **Backend API**: http://localhost:8001
- **Database Adminer**: http://localhost:8081

##  Quick Start with Docker

**For new users:** This is the easiest way to run the application. No need to install PHP, Node.js, or MySQL locally.

### Prerequisites
- [Docker Desktop](https://www.docker.com/products/docker-desktop) installed
- Git installed

### One-Command Setup

```bash
# Clone the repository
git clone <your-repository-url>
cd task-management-system

Stop Docker Containers
docker-compose down
# To also delete database data:
docker-compose down -v

Prerequisites
PHP 8.2+
Composer
Node.js 18+

Backend Setup (Laravel API)
cd backend
composer install
cp .env.example .env
php artisan key:generate

Update .env file
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3307
DB_DATABASE=task_manager
DB_USERNAME=root
DB_PASSWORD=rootpassword

Start MySQL with Docker:
docker run --name task-manager-mysql \
  -e MYSQL_ROOT_PASSWORD=rootpassword \
  -e MYSQL_DATABASE=task_manager \
  -p 3307:3306 \
  -d mysql:8.0

# 2. Start Adminer container (to view database)
docker run -d --name task-manager-adminer \
  -p 8081:8080 \
  adminer

Run migrations and start server
php artisan migrate --seed
php artisan serve

Backend runs on http://localhost:8001

Frontend Setup (Next.js)
cd frontend
npm install
echo "NEXT_PUBLIC_API_URL=http://localhost:8001" > .env.local
npm run dev

Database GUI (Adminer)
docker run -d --name task-manager-adminer -p 8081:8080 adminer


Assumptions Made:

1. No authentication required
2. No email notifications
3. Local development only

Libraries Used:

Backend

Library	 Version	
Laravel	 13.x	    
MySQL	 8.0	    

Frontend

Library	   Version	
Next.js	   14.x	
TypeScript 5.x	
Tailwind   CSS	
React	   18.x	

DevOps

Tool	Purpose
Docker	Containerization
Adminer	Database Management
Git	    Version Control

Architecture Decisions

1. API-First Design
- RESTful API enables multiple frontend clients
- Clear separation of concerns
- JSON responses for easy consumption

2. Laravel 13 Structure
- Modern routing in bootstrap/app.php
- Form Requests for validation
- Eloquent ORM with query scopes
- Controllers with proper HTTP status codes

3. Next.js App Router
- Modern App Router over Pages Router
- Client components with 'use client' directive
- Server-side rendering for initial load

4. Database Design
tasks table:
- id (primary key)
- title (string, indexed)
- description (text, nullable)
- status (enum: pending/completed)
- priority (enum: low/medium/high)
- created_at, updated_at (timestamps)

TaskForm (create tasks)
    ↓
TaskList (display tasks)
    ↓
TaskCard (individual task with edit/delete)


What Would Improve With More Time

1. Authentication
2. Add seperate page for it display like :
- Frontpage show the Your Tasks
- Add new task task need to go another page

- Check the EdgeCase.md for testing to prevent duplicate tasks with same title within 10 seconds
