
# Laravel Hotel Management System

This is a Laravel conversion of the React-based Hotel Management System. This conversion focuses on the UI design, pages, and components without implementing the database functionality.

## Setup Instructions

1. Clone this repository
2. Run `composer install` to install PHP dependencies
3. Copy `.env.example` to `.env` and configure your environment
4. Run `php artisan key:generate` to generate an application key
5. Run `npm install` to install frontend dependencies
6. Run `npm run dev` to compile assets
7. Run `php artisan serve` to start the development server

## Project Structure

- `app/` - Contains the core code of the application
- `resources/views/` - Contains the Blade templates
- `resources/js/` - Contains JavaScript files
- `resources/css/` - Contains CSS files
- `public/` - Contains publicly accessible files
- `routes/` - Contains route definitions

## Features

- Dashboard with stats and charts
- Booking management
- Room management
- Owner portal
- User management
- Report generation
