
# Hotel Management System - Laravel Version

This is a PHP/Laravel implementation of the Hotel Management System, based on the design specifications in the original React/TypeScript project.

## Project Structure

- `app/` - Contains the core code of the application
  - `Http/Controllers/` - Controller classes
  - `Models/` - Eloquent models
  - `Services/` - Service classes for business logic
- `resources/views/` - Blade templates
  - `components/` - Reusable UI components
  - `layouts/` - Page layouts
  - `pages/` - Individual page templates
- `public/` - Publicly accessible files
  - `css/` - Compiled CSS files
  - `js/` - Compiled JavaScript files
  - `images/` - Image assets
- `routes/` - Application routes
  - `web.php` - Web routes

## Installation Instructions

1. Clone the repository
2. Run `composer install`
3. Copy `.env.example` to `.env` and configure your database
4. Run `php artisan key:generate`
5. Run `php artisan migrate --seed`
6. Run `npm install`
7. Run `npm run dev`
8. Run `php artisan serve`
9. Visit `http://localhost:8000` in your browser

## Authentication

The system includes separate authentication for:
- Staff members (reception, housekeeping, management)
- Property owners

## Features

- Dashboard with key metrics
- Booking management
- Room management
- Cleaning status tracking
- Expense tracking
- User management
- Owner portal
- Reports
- Audit logs
