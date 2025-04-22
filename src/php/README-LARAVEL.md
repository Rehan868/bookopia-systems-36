
# Laravel Implementation of Hotel Management System

This is a PHP/Laravel implementation of the Hotel Management System, converted from the original React/TypeScript application. It maintains the same design aesthetic and functionality while utilizing Laravel's powerful features.

## Features

- **Authentication**: Separate authentication flows for staff and property owners
- **Dashboard**: Overview of key metrics, recent bookings, and activities
- **Booking Management**: Create, view, edit, and manage bookings
- **Room Management**: Add, edit, and view rooms across properties
- **Cleaning Status**: Monitor and update room cleaning status
- **Expenses**: Track and manage property expenses
- **User Management**: Admin-only section to manage staff accounts
- **Owner Management**: Manage property owners and their properties
- **Reports**: Generate and view various reports
- **Audit Logs**: Track system activity for security and compliance
- **Settings**: Configure system settings

## Technical Overview

### Frontend

- **Blade Templates**: All UI components built with Laravel Blade
- **TailwindCSS**: Used for styling, maintaining the same classes from the React version
- **AlpineJS**: Minimal JavaScript for interactive components
- **ApexCharts**: For data visualization

### Backend

- **Laravel Controllers**: Organized by feature (BookingController, RoomController, etc.)
- **Eloquent Models**: Object-relational mapping for database interactions
- **Laravel Authentication**: Built-in auth system adapted for multi-role support
- **Form Validation**: Server-side validation using Laravel's validation system
- **Route Protection**: Middleware for role-based access control

## Implementation Details

1. **Authentication**:
   - Custom middleware for role-based access (`staff`, `admin`, `owner`)
   - Separate login screens for staff and owners
   - Protection of routes based on user role

2. **Database Structure**:
   - Users table with role column
   - Bookings, Rooms, Properties, Expenses tables
   - Join tables for relationships
   - Migration files for database setup

3. **UI Components**:
   - Shared layout components (header, sidebar)
   - Reusable card, table, and form components
   - Status badges and icons consistent with original design

4. **Reports**:
   - Dynamic report generation
   - Export to CSV/PDF functionality
   - Visual data representations

## Setup Instructions

1. Clone the repository
2. Run `composer install`
3. Copy `.env.example` to `.env` and configure your database
4. Run `php artisan key:generate`
5. Run `php artisan migrate --seed` (seeds the database with sample data)
6. Run `npm install && npm run dev` (to compile assets)
7. Run `php artisan serve`
8. Visit http://localhost:8000 in your browser

## Development Approach

The conversion from React to Laravel maintained the following principles:

1. **Preserve UI/UX**: The same visual design and user experience was maintained
2. **Leverage Laravel Features**: Using built-in Laravel capabilities rather than reinventing the wheel
3. **Minimize JavaScript**: Using server-rendered pages where possible, with minimal JS for interactivity
4. **Maintain Data Relationships**: Preserving the same data structure and relationships
5. **RESTful Routes**: Following Laravel conventions for resource routes
