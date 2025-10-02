# Todo List Application

A simple yet effective task management application built with Yii2 framework.

## Features

- Add tasks with categories
- Delete tasks  
- Real-time updates via AJAX
- Clean, responsive UI
- MySQL database backend

## Requirements

- PHP 8.0+
- MySQL 5.7+
- Composer

## Installation

1. Clone the repository
2. Run `composer install`
3. Configure database in `config/env.php`
4. Import database schema: `mysql -u admin -p todo_app < setup.sql`
5. Start server: `php yii serve`

## Usage

Navigate to `http://localhost:8080` in your browser.

- Select a category
- Type your task
- Click "Add Task"
- Delete tasks by clicking the Delete button

## Tech Stack

- **Backend**: Yii2 Framework
- **Frontend**: jQuery, Bootstrap 4
- **Database**: MySQL

## Project Structure

```
├── controllers/     # Application controllers
├── models/         # Data models
├── views/          # View templates
├── config/         # Configuration files
├── web/           # Public web directory
└── commands/      # Console commands
```

