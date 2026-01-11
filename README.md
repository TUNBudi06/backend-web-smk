<div align="center">

# 🎓 Backend Web SMK

### Comprehensive Backend API for Vocational High School Management System

[![Laravel](https://img.shields.io/badge/Laravel-12.x-FF2D20?style=for-the-badge&logo=laravel&logoColor=white)](https://laravel.com)
[![PHP](https://img.shields.io/badge/PHP-8.2+-777BB4?style=for-the-badge&logo=php&logoColor=white)](https://php.net)
[![License](https://img.shields.io/badge/License-MIT-green.svg?style=for-the-badge)](LICENSE)
[![API](https://img.shields.io/badge/API-REST-blue?style=for-the-badge)](https://swagger.io)

[Features](#-features) • [Tech Stack](#-tech-stack) • [Installation](#-installation) • [API Documentation](#-api-documentation) • [Contributing](#-contributing)

</div>

---

## 📖 About

**Backend Web SMK** is a robust and scalable RESTful API backend system designed specifically for Vocational High Schools (Sekolah Menengah Kejuruan). This system provides comprehensive management capabilities for school operations, content management, student information, partnerships, job opportunities, and more.

### 🎯 Purpose

This backend serves as the data layer and business logic provider for SMK web applications, enabling:
- **Content Management**: News, articles, announcements, events, and galleries
- **Academic Management**: Student data (Peserta Didik), teacher data (PTK), learning devices (Perangkat Ajar)
- **Department Management**: Programs (Jurusan/Prodi), facilities, and extracurricular activities
- **Partnership Management**: Company partnerships (Kemitraan), job opportunities (Lowongan Kerja/Loker)
- **School Profile**: Vision & mission, structure, principal's welcome message, and committees
- **E-Learning Integration**: Online learning materials and resources

---

## ✨ Features

### 📰 Content Management
- **News (Berita)**: School news with categories, images, and rich text editor
- **Articles (Artikel)**: Educational articles with categorization
- **Announcements (Pengumuman)**: Important school announcements
- **Events (Agenda)**: School event calendar and management
- **Gallery (Galeri)**: Image galleries with categories

### 👥 User & Academic Management
- **Authentication**: Secure login with Sanctum token-based authentication
- **Role-Based Access Control**: Admin, Teacher, Staff permissions
- **Student Data (Peserta Didik)**: Comprehensive student information with Excel import
- **Teacher Data (PTK)**: Teacher and staff management with Excel import
- **Learning Devices (Perangkat Ajar)**: Teaching materials and document management

### 🏫 School Information
- **Departments (Jurusan/Prodi)**: 
  - Department profiles with descriptions
  - Vision & mission
  - Organization structure (PDF embed)
  - Department logos and banners
- **Facilities (Fasilitas)**: School facilities showcase
- **Extracurricular (Ekstra)**: Extracurricular activities with badges
- **Videotron**: YouTube video embeds (primary and secondary)

### 🤝 Partnerships & Career
- **Partnerships (Kemitraan)**: 
  - Company partnerships
  - Partner logos
  - Collaboration details
  - Partnership videos
- **Job Opportunities (Lowongan Kerja)**: 
  - Job postings
  - Position management
  - Career opportunities for alumni

### 🔗 Dynamic Content
- **Navigation Menu**: Dynamic navbar and sub-navbar management
- **Footer Links**: Social media and contact information
- **Sliders**: Homepage advantage sliders
- **Other Links**: Committees, work programs, vision & mission, structure

### 📚 E-Learning
- **Learning Materials**: Online course content
- **Resource Management**: Educational resources and materials

---

## 🛠️ Tech Stack

### Core Framework
- **[Laravel 12.x](https://laravel.com)** - The PHP Framework for Web Artisans
- **[PHP 8.2+](https://php.net)** - Modern PHP with latest features

### Key Packages
| Package | Purpose | Version |
|---------|---------|---------|
| [Laravel Sanctum](https://laravel.com/docs/sanctum) | API Authentication | ^4.0 |
| [L5-Swagger](https://github.com/DarkaOnLine/L5-Swagger) | API Documentation | ^9.0 |
| [Intervention Image](https://image.intervention.io) | Image Processing | ^3.5 |
| [Maatwebsite Excel](https://laravel-excel.com) | Excel Import/Export | ^3.1 |
| [Laravel Boost](https://boost.laravel.com) | Development Tools | ^1.8 |

### Development Tools
- **PHPUnit** - Testing framework
- **Laravel Pint** - Code style fixer
- **Spatie Ignition** - Error page debugger
- **Laravel Tinker** - REPL for Laravel

---

## 📋 Prerequisites

Before installation, ensure your system meets these requirements:

- **PHP** >= 8.2
- **Composer** >= 2.0
- **MySQL** >= 8.0 or **MariaDB** >= 10.3
- **Node.js** >= 18.x (for asset compilation)
- **PDO PHP Extension**
- **Other PHP Extensions**: OpenSSL, PDO, Mbstring, Tokenizer, XML, Ctype, JSON, BCMath, Fileinfo

---

## 🚀 Installation

### 1. Clone the Repository
```bash
git clone https://github.com/yourusername/backend-web-smk.git
cd backend-web-smk
```

### 2. Install Dependencies
```bash
composer install
```

### 3. Environment Configuration
```bash
# Copy environment file
cp .env.example .env

# Generate application key
php artisan key:generate
```

### 4. Database Setup
Edit `.env` file with your database credentials:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=backend_web_smk
DB_USERNAME=your_username
DB_PASSWORD=your_password
```

Run migrations and seeders:
```bash
# Create database tables
php artisan migrate

# Seed initial data (optional)
php artisan db:seed
```

### 5. Storage & Permissions
```bash
# Create symbolic link for storage
php artisan storage:link

# Set proper permissions (Unix/Linux/Mac)
chmod -R 775 storage bootstrap/cache
```

### 6. Generate API Documentation
```bash
php artisan l5-swagger:generate
```

### 7. Start Development Server
```bash
php artisan serve
```

Your application will be available at `http://localhost:8000`

---

## 📚 API Documentation

### Swagger/OpenAPI Documentation
Once the application is running, access the interactive API documentation:

```
http://localhost:8000/api/documentation
```

### API Base URL
```
http://localhost:8000/api
```

### Authentication
This API uses **Laravel Sanctum** for authentication. Include the bearer token in your requests:

```http
Authorization: Bearer {your_token}
```

### Available Endpoints

#### 🔐 Authentication
```http
POST   /api/auth/login          # User login
POST   /api/auth/register       # User registration
POST   /api/auth/logout         # User logout
GET    /api/auth/me             # Get authenticated user
```

#### 📰 News & Articles
```http
GET    /api/news                # Get all news
GET    /api/news/{id}           # Get news by ID
POST   /api/news                # Create news (admin)
PUT    /api/news/{id}           # Update news (admin)
DELETE /api/news/{id}           # Delete news (admin)

GET    /api/articles            # Get all articles
GET    /api/articles/{id}       # Get article by ID
```

#### 📢 Announcements & Events
```http
GET    /api/pengumuman          # Get announcements
GET    /api/pengumuman/{id}     # Get announcement by ID

GET    /api/events              # Get events
GET    /api/events/{id}         # Get event by ID
```

#### 🎓 Academic Management
```http
GET    /api/peserta-didik       # Get students
GET    /api/ptk                 # Get teachers/staff
GET    /api/perangkat-ajar      # Get learning devices
```

#### 🏢 Departments & Facilities
```http
GET    /api/jurusan             # Get departments
GET    /api/jurusan/{id}        # Get department details
GET    /api/fasilitas           # Get facilities
GET    /api/ekstra              # Get extracurricular
```

#### 🤝 Partnerships & Jobs
```http
GET    /api/kemitraan           # Get partnerships
GET    /api/loker               # Get job opportunities
GET    /api/loker/{id}          # Get job details
```

#### 🖼️ Gallery
```http
GET    /api/gallery             # Get galleries
GET    /api/gallery/{id}        # Get gallery by ID
```

#### 🔗 Profile & Links
```http
GET    /api/user/profile/komite-sekolah        # School committee
GET    /api/user/profile/program-kerja         # Work program
GET    /api/user/profile/visi-misi            # Vision & mission
GET    /api/user/profile/struktur             # Organization structure
GET    /api/user/profile/sambutan/Kepala-sekolah  # Principal's message
```

#### 🧭 Navigation
```http
GET    /api/navbar              # Get navigation menu
GET    /api/footer              # Get footer links
```

---

## 📁 Project Structure

```
backend-web-smk/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── api/          # API Controllers
│   │   │   ├── url/          # Web Controllers
│   │   │   └── ...
│   │   ├── Middleware/       # Custom Middleware
│   │   ├── Requests/         # Form Requests
│   │   └── Resources/        # API Resources
│   ├── Models/               # Eloquent Models
│   └── Imports/              # Excel Import Classes
├── database/
│   ├── migrations/           # Database Migrations
│   ├── seeders/              # Database Seeders
│   └── factories/            # Model Factories
├── routes/
│   ├── api.php               # API Routes
│   ├── web.php               # Web Routes
│   └── console.php           # Console Routes
├── public/
│   ├── img/                  # Images
│   ├── data-pdf/             # PDF Files
│   ├── data-perangkatAjar/   # Teaching Materials
│   └── ...
├── resources/
│   └── views/                # Blade Templates
├── storage/
│   ├── api-docs/             # Swagger Documentation
│   └── logs/                 # Application Logs
├── tests/
│   ├── Feature/              # Feature Tests
│   └── Unit/                 # Unit Tests
└── ...
```

---

## 🧪 Testing

### Run Tests
```bash
# Run all tests
php artisan test

# Run specific test
php artisan test --filter=OtherControllerTest

# Run with coverage
php artisan test --coverage
```

### Test Coverage
- ✅ Feature tests for critical functionalities
- ✅ API endpoint testing
- ✅ Controller logic testing
- ✅ Validation testing

---

## 🔧 Configuration

### File Upload Configuration
Edit `config/filesystems.php` for storage configuration:
```php
'public' => [
    'driver' => 'local',
    'root' => storage_path('app/public'),
    'url' => env('APP_URL').'/storage',
    'visibility' => 'public',
],
```

### Image Processing
Maximum upload sizes are configured in the controllers:
- **Images**: 10MB (jpeg, png, jpg, gif, webp)
- **Documents**: 10MB (pdf, doc, docx)

### Excel Import
Uses Maatwebsite Excel for bulk data import:
- Student data import via Excel
- Teacher/staff data import via Excel

---

## 📝 Database Schema

### Key Tables
- `tb_admin` - Admin users
- `tb_news` - News posts
- `tb_artikel` - Articles
- `tb_pengumuman` - Announcements
- `tb_event` - Events/agenda
- `tb_gallery` - Image galleries
- `tb_peserta_didik` - Students
- `tb_ptk` - Teachers and staff
- `tb_jurusan` - Departments
- `tb_prodi` - Study programs
- `tb_fasilitas` - Facilities
- `tb_extra` - Extracurricular activities
- `tb_kemitraan` - Partnerships
- `tb_loker` - Job opportunities
- `tb_perangkatAjar` - Learning devices
- `tb_navbar` - Navigation menu
- `tb_other` - Other content (profile, links)
- `tb_elearning` - E-learning materials

---

## 🔒 Security

### Best Practices Implemented
- ✅ **CSRF Protection** - Automatic CSRF token validation
- ✅ **XSS Protection** - Input sanitization and escaping
- ✅ **SQL Injection Prevention** - Eloquent ORM with prepared statements
- ✅ **Authentication** - Sanctum token-based authentication
- ✅ **Authorization** - Role-based access control
- ✅ **File Upload Validation** - Strict MIME type and size validation
- ✅ **Password Hashing** - Bcrypt hashing for passwords
- ✅ **Rate Limiting** - API request throttling

### Security Headers
Configure in `app/Http/Middleware`:
- Content Security Policy
- X-Frame-Options
- X-Content-Type-Options

---

## 🚀 Deployment

### Production Checklist
- [ ] Set `APP_ENV=production` in `.env`
- [ ] Set `APP_DEBUG=false` in `.env`
- [ ] Configure proper database credentials
- [ ] Run `php artisan config:cache`
- [ ] Run `php artisan route:cache`
- [ ] Run `php artisan view:cache`
- [ ] Set proper file permissions
- [ ] Configure web server (Nginx/Apache)
- [ ] Enable HTTPS/SSL
- [ ] Set up daily backups
- [ ] Configure log rotation

### Server Requirements
- **PHP** 8.2+ with required extensions
- **MySQL** 8.0+ or **MariaDB** 10.3+
- **Nginx** or **Apache** with mod_rewrite
- **Composer** for dependency management
- **Supervisor** for queue workers (if using queues)

---

## 🤝 Contributing

Contributions are welcome! Please follow these steps:

1. **Fork** the repository
2. **Create** a feature branch (`git checkout -b feature/AmazingFeature`)
3. **Commit** your changes (`git commit -m 'Add some AmazingFeature'`)
4. **Push** to the branch (`git push origin feature/AmazingFeature`)
5. **Open** a Pull Request

### Coding Standards
- Follow **PSR-12** coding standards
- Use **Laravel Pint** for code formatting: `./vendor/bin/pint`
- Write tests for new features
- Update documentation as needed

---

## 📖 Documentation

Additional documentation files:
- 📄 [Refactoring Documentation](REFACTORING_DOCUMENTATION.md) - Technical refactoring details
- 📄 [Quick Reference Guide](QUICK_REFERENCE.md) - Developer quick reference
- 📄 [Todolist Backend](Todolist-BE.md) - Feature development roadmap

---

## 🐛 Troubleshooting

### Common Issues

#### Issue: "Storage link not found"
```bash
php artisan storage:link
```

#### Issue: "Permission denied"
```bash
chmod -R 775 storage bootstrap/cache
```

#### Issue: "Class not found"
```bash
composer dump-autoload
```

#### Issue: "Database connection failed"
- Check `.env` database credentials
- Ensure MySQL service is running
- Verify database exists

#### Issue: "Route not found"
```bash
php artisan route:clear
php artisan cache:clear
```

---

## 📄 License

This project is licensed under the **MIT License** - see the [LICENSE](LICENSE) file for details.

---

## 👥 Team & Credits

### Development Team
- Backend Development
- API Design
- Database Architecture
- System Administration

### Built With
- [Laravel Framework](https://laravel.com) - The PHP Framework for Web Artisans
- [Swagger/OpenAPI](https://swagger.io) - API Documentation
- [Intervention Image](https://image.intervention.io) - Image Processing Library
- [Maatwebsite Excel](https://laravel-excel.com) - Excel Import/Export

---

## 📞 Support & Contact

For questions, issues, or feature requests:
- 📧 Email: support@yourschool.com
- 🐛 Issues: [GitHub Issues](https://github.com/yourusername/backend-web-smk/issues)
- 📖 Documentation: [API Docs](http://localhost:8000/api/documentation)

---

## 🎯 Roadmap

### Current Version (v2.0)
- ✅ Core API endpoints
- ✅ Authentication & authorization
- ✅ Content management
- ✅ Academic management
- ✅ Partnership management
- ✅ Excel import functionality
- ✅ API documentation

### Future Enhancements
- 🔄 Real-time notifications
- 🔄 Advanced search functionality
- 🔄 Multi-language support
- 🔄 Mobile app integration
- 🔄 Analytics dashboard
- 🔄 Email notifications
- 🔄 SMS integration
- 🔄 Report generation

---

## 🌟 Acknowledgments

Special thanks to:
- Laravel community for the amazing framework
- All contributors who have helped improve this project
- Open source community for the excellent packages

---

<div align="center">

### ⭐ Star this repository if you find it helpful!

Made with ❤️ for Indonesian Vocational High Schools

**[Back to Top](#-backend-web-smk)**

</div>
