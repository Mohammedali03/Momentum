# Laravel To-Do App

![alt text](image-3.png)


## Description

This is a simple To-Do application built with Laravel. It allows users to create, update, and delete tasks. Tasks are dynamically updated with a status (completed or pending), and the app provides a user-friendly interface for task management.

## Features

- **User Authentication**: Users can register, log in, and manage their tasks.
- **Create Tasks**: Users can create new tasks with a title and description.
- **Update Task Status**: Tasks can be marked as completed or pending.
- **Delete Tasks**: Users can delete tasks from their to-do list.
- **Task List**: A view to display all tasks, with status and options to update or delete.

## Installation

### Prerequisites

Make sure you have the following installed on your system:
- PHP >= 7.4
- Composer
- Laravel
- MySQL (or your preferred database)

### Steps

1. **Clone the repository**:
   ```bash
   git clone https://github.com/Mohammedali03/To_Do-App.git
   Navigate to the project folder:

bash
Copier
Modifier
cd todo-app
Install the dependencies: Run the following command to install the necessary dependencies via Composer:

bash
Copier
Modifier
composer install
Set up the environment:

Copy the .env.example file to .env:
bash
Copier
Modifier
cp .env.example .env
Generate the application key:
bash
Copier
Modifier
php artisan key:generate
Update your database settings in .env. For example:
env
Copier
Modifier
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=your_database_name
DB_USERNAME=your_database_username
DB_PASSWORD=your_database_password
Migrate the database: Run the migrations to create the necessary tables for the application:

bash
Copier
Modifier
php artisan migrate
Seed the database (optional): If you'd like to seed the database with sample data, you can run the following command:

bash
Copier
Modifier
php artisan db:seed
Serve the application: Start the Laravel development server:

bash
Copier
Modifier
php artisan serve


details of a task section 
![alt text](image-2.png)

