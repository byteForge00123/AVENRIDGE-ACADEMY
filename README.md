# AVENRIDGE ACADEMY — Learn. Connect. Belong.

A welcoming school website and student community platform built with **Laravel 13**, **PHP 8.3+**, **Blade**, **Tailwind CSS 4**, **Alpine.js**, **Lucide**, **Vite**, and **MySQL**. Students can take part in an anonymous, moderated community and submit private school concerns with status-only tracking.

![Laravel](https://img.shields.io/badge/Laravel-13-FF2D20?style=flat-square&logo=laravel&logoColor=white)
![PHP](https://img.shields.io/badge/PHP-8.3%2B-777BB4?style=flat-square&logo=php&logoColor=white)
![Blade](https://img.shields.io/badge/Blade-Server--Rendered-F05340?style=flat-square&logo=laravel&logoColor=white)
![Tailwind CSS](https://img.shields.io/badge/Tailwind%20CSS-4-06B6D4?style=flat-square&logo=tailwindcss&logoColor=white)
![Alpine.js](https://img.shields.io/badge/Alpine.js-3-8BC0D0?style=flat-square&logo=alpinedotjs&logoColor=white)
![Vite](https://img.shields.io/badge/Vite-8-646CFF?style=flat-square&logo=vite&logoColor=white)

## ✨ Features

- **School website**: Editorial home page and dedicated About, Programs, Admissions, Faculty, Campus, News & Events, and Contact pages.
- **Student community**: Anonymous posts and replies, search, topic filtering, and post reporting.
- **Moderation before publishing**: New posts and replies stay pending until staff or an administrator approves them.
- **Private concern reports**: Submit bullying, safety, academic, and other concerns with an optional private attachment.
- **Reference tracking**: Students can check a report's current status without seeing investigation notes or sensitive details.
- **Role-based workspace**: Admins manage school content, users, and roles. Staff review community content and work on assigned reports.
- **School content manager**: Create, edit, publish, and remove programs, news, events, faculty profiles, facilities, and gallery items.
- **Responsive and accessible UI**: Mobile navigation, semantic forms, visible focus treatment, and reduced-motion support.
- **Reusable school branding**: Name, tagline, address, contact details, and office hours are configurable through environment variables.

## 🚀 Pages & Workflows

- **Home**: School introduction, programs, campus life, news, events, community, and admissions links.
- **About**: Mission, vision, values, school history, and head-of-school message.
- **Programs**: Grade-level programs and subject areas.
- **Admissions**: Application steps, timing, requirements, and common questions.
- **Faculty & Staff**: Fictional sample profiles for local development.
- **Campus**: Facilities and gallery.
- **News & Events**: Searchable and filterable published stories with upcoming dates.
- **Contact**: School details and contact form.
- **Student Community**: Anonymous posts, replies, filters, and report-post action.
- **Report a Concern / Track a Report**: Private submission and reference-number status lookup.
- **Admin workspace**: Dashboard, post/reply moderation, concern-case review, CMS, and user-role management.

## 📦 Tech Stack

| Technology | Version | Purpose |
| --- | --- | --- |
| Laravel | 13.x | Server-side application framework and routing |
| PHP | 8.3+ | Application runtime |
| Blade | Laravel 13 | Server-rendered templates |
| Tailwind CSS | 4.x | CSS build pipeline and utility styling |
| Alpine.js | 3.x | Lightweight interface behavior |
| Lucide | 1.x | Interface icons |
| Vite | 8.x | Frontend development and production builds |
| MySQL | 8+ | Recommended shared/production database |
| SQLite | Current PHP driver | Local development and automated tests |

## 🔧 Installation

### Prerequisites

- PHP 8.3+ with `ctype`, `curl`, `fileinfo`, `mbstring`, `openssl`, `pdo_mysql` or `pdo_sqlite`, `tokenizer`, `xml`, and `zip`.
- Composer 2.
- Node.js 20.19+ or 22.12+ and npm.
- MySQL 8+ for a shared or production deployment. SQLite is available for local development.

### Setup

1. **Install backend and frontend dependencies**

	```powershell
	composer install
	Copy-Item .env.example .env
	php artisan key:generate
	npm install
	```

2. **Choose a database**

	For MySQL, create a database and configure `.env`:

	```dotenv
	DB_CONNECTION=mysql
	DB_HOST=127.0.0.1
	DB_PORT=3306
	DB_DATABASE=avenridge
	DB_USERNAME=your_database_user
	DB_PASSWORD=your_database_password
	```

	For SQLite, set `DB_CONNECTION=sqlite`, create `database/database.sqlite` if needed, and enable PHP's `pdo_sqlite` and `sqlite3` extensions.

3. **Create tables and fictional development data**

	```powershell
	php artisan migrate --seed
	```

4. **Build assets and start Laravel**

	```powershell
	npm run build
	php artisan serve
	```

	Visit [http://127.0.0.1:8000](http://127.0.0.1:8000). For frontend development, run `npm run dev` in a second terminal.

### Windows Portable PHP

On the original development machine, PHP is installed in the user's local AppData directory and is not added to `PATH`. Use the repository helper for Artisan commands:

```powershell
.\scripts\artisan.ps1 migrate --seed
.\scripts\artisan.ps1 test
.\scripts\artisan.ps1 serve --host=127.0.0.1 --port=8000
```

On other machines with PHP available on `PATH`, use `php artisan` directly.

## 🔐 Local Demo Accounts

The development seeder creates fictional accounts:

| Role | Email | Password |
| --- | --- | --- |
| Admin | `admin@avenridge.test` | `ChangeMe123!` |
| Staff | `mara.ellis@avenridge.test` | `ChangeMe123!` |
| Student | `jordan.lee@avenridge.test` | `ChangeMe123!` |

These credentials are for local evaluation only. Set `AVENRIDGE_ADMIN_EMAIL` and a unique `AVENRIDGE_ADMIN_PASSWORD` in `.env` before local seeding. **Never deploy these demo accounts or run the sample seeder in production.** Provision production accounts securely and rotate credentials.

## 🧪 Tests

```powershell
php artisan test
```

On the portable-PHP Windows setup:

```powershell
.\scripts\artisan.ps1 test
```

Feature tests cover anonymous post/reply behavior, moderation, concern-tracking privacy, role boundaries, content management, and student registration.

## 🎨 Customization

### School identity

Set these variables in `.env`; their defaults are defined in `config/avenridge.php`:

```dotenv
SCHOOL_NAME="Avenridge Academy"
SCHOOL_TAGLINE="Learn. Connect. Belong."
SCHOOL_CONTACT_EMAIL=office@example.edu
SCHOOL_PHONE="+1 (555) 010-2026"
SCHOOL_ADDRESS="Your school address"
SCHOOL_OFFICE_HOURS="Monday-Friday, 8:00 am-4:00 pm"
```

### Content and appearance

- Manage programs, news, events, faculty, facilities, and gallery items from the admin workspace at `/admin/content/{type}`.
- Manage users and roles at `/admin/users` as an administrator.
- Update palette, typography, focus styling, and responsive layouts in `resources/css/app.css`.
- Update reusable navigation, footer, and document shell in `resources/views/layouts/app.blade.php`.
- Replace fictional sample copy and seed records in `database/seeders/AvenridgeSeeder.php` with approved school content.
- Use school-owned or properly licensed images when replacing sample image URLs.

## 🔒 Privacy & Production Readiness

- Public posts and replies display as **Anonymous Student**; pending content is not public.
- Concern descriptions, identities, and attachments are excluded from public tracking pages. Attachments are stored on Laravel's private disk and delivered through staff authorization checks.
- Report reference numbers act as bearer references. Students should keep them private.
- Before accepting real student information, configure HTTPS, MySQL, secure session settings, durable private file storage, backups, email delivery, monitoring, and rate-limit storage shared by all application instances.
- Establish an approved retention, safeguarding, and escalation process with school administrators. This starter implementation is not a substitute for the school's safeguarding policy.
- Configure `MAIL_MAILER`, SMTP credentials, and sender details before relying on the contact form; the default local mail transport is for development.
- Replace all demo credentials and fictional data before deployment. Set `APP_DEBUG=false` and use production secrets.

## 📂 Project Structure

```text
app/
├── Http/
│   ├── Controllers/       # Public pages, community, concerns, auth, admin/CMS
│   └── Middleware/        # Role checks
└── Models/                # Eloquent models
config/avenridge.php       # Customizable school identity
database/
├── migrations/            # Users, school content, posts, replies, reports
└── seeders/               # Fictional local development data
resources/
├── css/app.css            # Design system and responsive styles
├── js/app.js              # Alpine.js and Lucide setup
└── views/                 # Public, student, authentication, and admin Blade views
routes/web.php             # Public and role-protected routes
scripts/artisan.ps1        # Windows helper for portable local PHP
tests/Feature/             # Privacy, authorization, and workflow tests
```

## 🚢 Deployment Checklist

- Configure production MySQL credentials and run migrations with `php artisan migrate --force`.
- Build static assets with `npm run build`.
- Set `APP_ENV=production`, `APP_DEBUG=false`, `APP_URL`, and a secure `APP_KEY`.
- Configure HTTPS, mail transport, private evidence storage, backups, logs, queue/cache/session services, and monitoring.
- Create real admin/staff accounts through a secure process; remove all demo users and sample content.
- Verify access control, school privacy requirements, safeguarding procedures, and report retention before launch.
