# Griffith University Event Booking System (GUEBS)

A comprehensive web application built with Laravel for managing university events and bookings. This system allows students to discover and book events while providing organizers with powerful tools to manage events and track attendance.

## 🎯 Features

### Core Functionality

-   **Event Management**: Create, view, edit, and delete events with detailed information
-   **User Authentication**: Secure registration and login system with role-based access control
-   **Booking System**: Real-time event booking and cancellation with capacity management
-   **Category Filtering**: Dynamic event filtering by categories (Academic, Sports, Social, Cultural, Technology)
-   **Analytics Dashboard**: Comprehensive dashboard with booking statistics and occupancy rates
-   **Responsive Design**: Mobile-first design using Tailwind CSS with dark mode support

### User Roles

-   **Attendees**: Browse events, make bookings, view personal booking history
-   **Organizers**: Create and manage events, access analytics dashboard, view attendee lists

### Advanced Features

-   **AJAX Filtering**: Dynamic event filtering without page reloads
-   **Real-time Updates**: Live booking counts and capacity monitoring
-   **UUID-based URLs**: Secure and user-friendly event identification
-   **Dark Mode Toggle**: System preference detection with manual override
-   **Responsive Tables**: Mobile-optimized data display with horizontal scrolling
-   **Form Validation**: Comprehensive client-side and server-side validation

## 🚀 Getting Started

### Prerequisites

-   PHP 8.1 or higher
-   Composer 2.0+
-   Node.js 16+ & NPM
-   SQLite (default) or MySQL database
-   Git

### Installation

1. **Clone the repository**

```bash
git clone https://github.com/kevthefoo/myEventBookingSystem.git
cd myEventBookingSystem
```

2. **Install PHP dependencies**

```bash
composer install
```

3. **Install JavaScript dependencies**

```bash
npm install
```

4. **Environment setup**

```bash
cp .env.example .env
php artisan key:generate
```

5. **Configure database**

```bash
# For SQLite (default - recommended for development)
touch database/database.sqlite

# Edit .env file
DB_CONNECTION=sqlite
DB_DATABASE=/absolute/path/to/myEventBookingSystem/database/database.sqlite
```

6. **Run migrations and seeders**

```bash
php artisan migrate:fresh --seed
```

7. **Build assets**

```bash
npm run build
# or for development with hot reload
npm run dev
```

8. **Start the development server**

```bash
php artisan serve
```

Visit `http://localhost:8000` to access the application.

### Default Users (After Seeding)

-   **Organizer**: organizer@example.com / password
-   **Attendee**: attendee@example.com / password

## 📁 Project Structure

```
myEventBookingSystem/
├── app/
│   ├── Http/Controllers/          # Application controllers
│   │   ├── BookingController.php          # Booking management
│   │   ├── DashboardController.php        # Admin dashboard
│   │   └── EventDetailsController.php     # Event display logic
│   ├── Models/                    # Eloquent models
│   │   ├── Event.php                      # Event model with relationships
│   │   ├── Booking.php                    # Booking/attendance model
│   │   ├── Category.php                   # Event categorization
│   │   └── User.php                       # Enhanced user model
│   └── ...
├── database/
│   ├── migrations/                # Database schema definitions
│   ├── seeders/                   # Sample data generation
│   │   ├── CategorySeeder.php             # Event categories
│   │   ├── EventSeeder.php                # Sample events
│   │   └── UserSeeder.php                 # Test users
│   └── factories/                 # Model factories for testing
├── resources/
│   ├── views/                     # Blade templates
│   │   ├── home.blade.php                 # Main events listing
│   │   ├── eventdetails/                  # Event detail views
│   │   ├── mybookings/                    # User booking management
│   │   ├── admindashboard/                # Analytics dashboard
│   │   └── layouts/main.blade.php         # Main layout template
│   └── css/app.css                # Tailwind CSS configuration
├── routes/
│   ├── web.php                    # Web routes definition
│   └── api.php                    # API endpoints
├── tests/
│   ├── Feature/                   # Feature tests
│   │   ├── AttendeeActionsTest.php        # Attendee functionality
│   │   ├── GuestAccessTest.php            # Guest user tests
│   │   └── CategoryFilteringTest.php      # Category filtering
│   └── Unit/                      # Unit tests
└── public/
    ├── images/                    # Static assets
    └── build/                     # Compiled assets
```

## 🎨 Architecture

### MVC Pattern Implementation

The application follows Laravel's MVC (Model-View-Controller) architecture:

**Flow Example - Event Booking:**

```
User Request → Route → BookingController → Event Model → Database
                ↓
User Response ← Blade View ← BookingController ← Event Model ← Database
```

#### Models

-   **Event.php**: Manages event data, relationships (organizer, attendees, categories), and business logic
-   **Booking.php**: Handles booking operations using pivot table for user-event relationships
-   **Category.php**: Event categorization with filtering capabilities and visual styling
-   **User.php**: Enhanced user model with role-based permissions (attendee/organizer)

#### Controllers

-   **BookingController.php**: Handles all booking operations (create, cancel, view history)
-   **EventDetailsController.php**: Displays event information with booking analytics
-   **DashboardController.php**: Provides analytics and administrative functions

#### Views (Blade Templates)

-   **Responsive Components**: Mobile-first design with Tailwind CSS
-   **Interactive Features**: AJAX-powered filtering and real-time updates
-   **Accessibility**: WCAG compliant with proper semantic markup

## 🗃️ Database Schema

### Core Tables

**users**

```sql
- id (Primary Key)
- first_name, last_name
- email (unique), password
- role (attendee/organizer)
- email_verified_at, remember_token
- timestamps
```

**events**

```sql
- id (Primary Key)
- uuid (unique identifier for URLs)
- title, description
- date, time, location
- capacity (integer)
- organizer_id (Foreign Key → users.id)
- timestamps
```

**event_attendees** (Pivot Table)

```sql
- id (Primary Key)
- user_id (Foreign Key → users.id)
- event_id (Foreign Key → events.id)
- timestamps
- UNIQUE(user_id, event_id) # Prevent duplicate bookings
```

**categories**

```sql
- id (Primary Key)
- name, slug (unique)
- color (hex color code)
- icon (emoji/unicode)
- description
- is_active (boolean)
- timestamps
```

**event_categories** (Many-to-Many)

```sql
- event_id (Foreign Key → events.id)
- category_id (Foreign Key → categories.id)
- timestamps
```

### Relationships

-   User → Events (One-to-Many as organizer)
-   User ↔ Events (Many-to-Many as attendee via event_attendees)
-   Event ↔ Categories (Many-to-Many)

## 🔧 Configuration

### Environment Variables

```env
APP_NAME="Griffith University Event Booking System"
APP_ENV=local
APP_KEY=base64:...generated...
APP_DEBUG=true
APP_URL=http://localhost:8000

DB_CONNECTION=sqlite
DB_DATABASE=/absolute/path/to/database/database.sqlite

# Email Configuration (optional)
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=your-email@gmail.com
MAIL_PASSWORD=your-app-password
MAIL_ENCRYPTION=tls
```

### Seeding Data

```bash
# Reset and seed all data
php artisan migrate:fresh --seed

# Seed specific data
php artisan db:seed --class=UserSeeder
php artisan db:seed --class=CategorySeeder
php artisan db:seed --class=EventSeeder
```

## 🎮 Usage Guide

### For Attendees (Students)

1. **Browse Events**: View upcoming events on the homepage with category filtering
2. **Event Details**: Click events to view full information, location, and capacity
3. **Make Bookings**: Book available events with real-time capacity checking
4. **Manage Bookings**: View booking history and cancel future bookings
5. **Profile Management**: Update personal information and preferences

### For Organizers (Staff)

1. **Event Creation**: Create new events with detailed information and categorization
2. **Event Management**: Edit event details, monitor bookings, and manage capacity
3. **Analytics Dashboard**: View comprehensive statistics on event performance
4. **Attendee Management**: View attendee lists and booking analytics
5. **Real-time Monitoring**: Track booking trends and occupancy rates

## 🚀 API Endpoints

### Public Routes

```
GET  /                              # Homepage with events listing
GET  /events/{uuid}                 # Event details page
POST /login                         # User authentication
POST /register                      # User registration
```

### Authenticated Routes

```
POST /events/{uuid}/book            # Book an event
DELETE /events/{uuid}/cancel        # Cancel booking
GET  /mybookings                    # User's booking history
```

### Organizer Routes

```
GET  /admin/dashboard               # Analytics dashboard
GET  /eventmanager                  # Event management interface
POST /events                        # Create new event
PUT  /events/{uuid}                 # Update event
DELETE /events/{uuid}               # Delete event
```

### AJAX API Endpoints

```
GET  /api/events/filter             # Filter events by categories
POST /api/categories                # Create new category
```

## 🎨 UI/UX Features

### Responsive Design

-   **Desktop (1024px+)**: 3-column event grid, full navigation, sidebar filters
-   **Tablet (768px-1023px)**: 2-column grid, condensed navigation
-   **Mobile (<768px)**: Single column layout, hamburger menu, touch-friendly buttons

### Interactive Elements

-   **Real-time Filtering**: AJAX-powered category filtering without page reloads
-   **Dynamic Capacity**: Live booking counts and progress bars
-   **Status Indicators**: Color-coded booking status and event states
-   **Loading States**: Smooth transitions and loading indicators
-   **Form Validation**: Real-time validation with helpful error messages

### Accessibility Features

-   **Keyboard Navigation**: Full keyboard accessibility
-   **Screen Reader Support**: Proper ARIA labels and semantic HTML
-   **Color Contrast**: WCAG AA compliant color schemes
-   **Focus Management**: Clear focus indicators and logical tab order

## 🧪 Testing

### Test Structure

```
tests/
├── Feature/                        # Integration tests
│   ├── AttendeeActionsTest.php     # Attendee user flows
│   ├── GuestAccessTest.php         # Guest user limitations
│   ├── OrganiserActionsTest.php    # Organizer functionality
│   └── CategoryFilteringTest.php   # Filtering system
└── Unit/                           # Unit tests
    └── Models/                     # Model testing
```

### Running Tests

```bash
# Run all tests
php artisan test

# Run specific test suite
php artisan test tests/Feature/AttendeeActionsTest.php

# Run tests with coverage
php artisan test --coverage

# Run tests in parallel (faster)
php artisan test --parallel
```

### Test Database

Tests use a separate SQLite database (`:memory:`) to ensure isolation and speed.

## 🚀 Deployment

### Production Checklist

1. **Environment Configuration**

```bash
APP_ENV=production
APP_DEBUG=false
APP_URL=https://yourdomain.com
```

2. **Database Migration**

```bash
php artisan migrate --force
php artisan db:seed --class=CategorySeeder --force
```

3. **Optimization**

```bash
composer install --optimize-autoloader --no-dev
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan queue:restart
```

4. **Asset Building**

```bash
npm run build
```

5. **File Permissions**

```bash
chmod -R 755 storage/
chmod -R 755 bootstrap/cache/
```

6. **Web Server Configuration** (Apache/Nginx)

```apache
DocumentRoot /path/to/myEventBookingSystem/public
```

### Deployment Platforms

-   **Shared Hosting**: Upload files, configure database, run migrations
-   **VPS/Cloud**: Use deployment tools like Laravel Forge or Envoyer
-   **Docker**: Dockerfile included for containerized deployment

## 🤝 Contributing

### Development Setup

```bash
git clone https://github.com/kevthefoo/myEventBookingSystem.git
cd myEventBookingSystem
composer install
npm install
cp .env.example .env
php artisan key:generate
php artisan migrate:fresh --seed
npm run dev
```

### Contribution Guidelines

1. Fork the repository
2. Create a feature branch (`git checkout -b feature/amazing-feature`)
3. Follow PSR-12 coding standards
4. Write tests for new functionality
5. Commit with descriptive messages (`git commit -m 'Add booking cancellation feature'`)
6. Push to your branch (`git push origin feature/amazing-feature`)
7. Open a Pull Request with detailed description

### Code Standards

-   **PHP**: PSR-12 coding standard
-   **JavaScript**: ES6+ with consistent formatting
-   **CSS**: Tailwind CSS utilities, minimal custom CSS
-   **Comments**: PHPDoc for all public methods
-   **Testing**: Feature tests for user flows, unit tests for complex logic

## 🐛 Troubleshooting

### Common Issues

**Database Connection Error**

```bash
# Check database path in .env
DB_DATABASE=/absolute/path/to/database.sqlite

# Ensure file exists
touch database/database.sqlite
```

**Permission Errors**

```bash
chmod -R 775 storage/
chmod -R 775 bootstrap/cache/
```

**Asset Not Loading**

```bash
npm run build
php artisan storage:link
```

**Migration Errors**

```bash
php artisan migrate:fresh --seed
```

## 📄 License

This project is licensed under the MIT License - see the [LICENSE.md](LICENSE.md) file for details.

## 👥 Authors & Contributors

-   **Kevin** - _Initial development_ - [kevthefoo](https://github.com/kevthefoo)

## 🙏 Acknowledgments

-   **Griffith University** - Project requirements and educational context
-   **Laravel Framework** - Robust PHP framework with excellent documentation
-   **Tailwind CSS** - Utility-first CSS framework for rapid UI development
-   **Heroicons** - Beautiful hand-crafted SVG icons
-   **Laravel Community** - Extensive packages and community support

## 📞 Support

For support and questions:

-   Create an issue in the [GitHub repository](https://github.com/kevthefoo/myEventBookingSystem/issues)
-   Check the [Wiki](https://github.com/kevthefoo/myEventBookingSystem/wiki) for detailed documentation
-   Review [FAQ](https://github.com/kevthefoo/myEventBookingSystem/wiki/FAQ) for common questions

## 🔄 Changelog

### Version 1.0.0 (October 2025)

-   Initial release with core booking functionality
-   Responsive design with mobile support
-   Category filtering system
-   Admin dashboard with analytics
-   Comprehensive test suite
-   Dark mode support

---

**Built with ❤️ using Laravel 10, Tailwind CSS 3, and modern web technologies**

_Last updated: October 2, 2025_
