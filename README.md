# Laravel Admin Dashboard — Role & Permission Management

A secure and customizable admin dashboard built with **Laravel, PHP, MySQL, and Bootstrap**. This project provides admin authentication, role-based access control (RBAC), permission management, and user administration.

## 🚀 Project Overview

The Laravel Admin Dashboard is designed to manage users, roles, permissions, and administrative operations through a centralized interface.

It implements role-based authorization so that administrators can control which users can access specific pages and perform particular actions.

## ✨ Key Features

- **Authentication:** Secure admin login and logout.
- **Role Management:** Create and manage roles.
- **Permission Management:** Assign permissions to roles.
- **User Management:** Create, view, update, and delete users according to permissions.
- **Role-Based Access Control (RBAC):** Restrict access based on assigned roles and permissions.
- **Admin Dashboard:** Centralized administrative interface.
- **Profile Management:** Update administrator profile information.
- **Password Management:** Change passwords securely.
- **Form Validation:** Validate user input before processing.
- **Middleware Authorization:** Protect routes from unauthorized access.
- **Database Integration:** Manage application data using MySQL.

## 👥 Available Roles

### 1. Super Admin
- Manage all administrative users.
- Create, update, and manage roles.
- Create and assign permissions.
- Access all authorized administrative settings.
- Manage the overall dashboard and system configuration.

### 2. Admin
- Manage users and general administrative operations.
- Access permitted dashboard features.
- Perform actions allowed by assigned permissions.
- Manage records within the authorized scope.

### 3. Manager
- Access the dashboard and permitted reports.
- View assigned records.
- Manage authorized operational data.
- Access only the modules allowed by assigned permissions.

### 4. Staff
- Access permitted pages and assigned tasks.
- View authorized records.
- Perform only explicitly permitted operations.
- Cannot access restricted administrative settings.

**Note:** Actual access depends on the roles and permissions configured in the application. These descriptions represent the intended access model.

## 🔐 Role & Permission System

The application uses role-based access control to protect administrative features.

Example permission structure:

| Module | Permissions |
|---|---|
| Users | View, Create, Update, Delete |
| Roles | View, Create, Update, Delete |
| Permissions | View, Assign, Update |
| Dashboard | View |
| Profile | View, Update |
| Reports | View, Export |
| Settings | View, Update |

Permissions should be checked on the server using middleware, policies, or other authorization logic. Hiding a button in the interface alone does not secure an action.

## 🛠️ Technologies Used

- **Backend:** PHP, Laravel
- **Database:** MySQL
- **Frontend:** HTML, CSS, JavaScript, Bootstrap, Blade
- **Authentication:** Laravel authentication with an admin guard, if configured
- **Authorization:** Custom roles, permissions, and middleware
- **Dependency Management:** Composer
- **Frontend Build Tools:** Node.js and npm
- **Version Control:** Git and GitHub

## 📋 Requirements

Install the following before running the project:

- PHP version compatible with the project's `composer.json`
- Composer
- MySQL or MariaDB
- Node.js and npm, if frontend assets require building
- Git
- XAMPP or another local PHP development environment (optional)

## ⚙️ Installation & Setup

### Step 1: Clone the repository

```bash
git clone https://github.com/adashhytrix/laravel-admin-dashboard.git
cd laravel-admin-dashboard
```

Alternatively, download the repository ZIP and extract it into your development directory.

### Step 2: Install PHP dependencies

```bash
composer install
```

### Step 3: Configure environment variables

Create your local environment file:

```bash
cp .env.example .env
```

On Windows PowerShell, if needed:

```powershell
Copy-Item .env.example .env
```

Generate the application key:

```bash
php artisan key:generate
```

### Step 4: Configure the database

Create a MySQL database, for example:

```sql
CREATE DATABASE laravel_admin_dashboard;
```

Update the following values in your `.env` file:

```dotenv
APP_NAME="Laravel Admin Dashboard"
APP_ENV=local
APP_DEBUG=true
APP_URL=http://127.0.0.1:8000

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=laravel_admin_dashboard
DB_USERNAME=root
DB_PASSWORD=
```

Change the database username and password to match your local MySQL configuration.

### Step 5: Run migrations

```bash
php artisan migrate
```

If the project includes seeders for roles, permissions, or a test administrator, run them according to the project's implementation:

```bash
php artisan db:seed
```

Only use seeders that are actually provided by the project. If no administrator seeder exists, create the initial administrator through a secure setup process.

### Step 6: Install frontend dependencies

If the project contains `package.json`, run:

```bash
npm install
npm run build
```

During frontend development, you can instead run:

```bash
npm run dev
```

Keep the Vite development process running in a separate terminal when using `npm run dev`.

### Step 7: Start the Laravel server

```bash
php artisan serve
```

Open the application at:

**http://127.0.0.1:8000**

If your project uses a custom admin login route, open the configured login URL, such as `/admin/login`.

## 🔑 Admin Login

After installation:

1. Open the admin login page.
2. Enter the credentials of an administrator created through your project's setup or seeder.
3. Sign in to access the dashboard.
4. Manage users, roles, and permissions according to your assigned access rights.

**Important:** No default username or password is assumed by this documentation. Use the credentials actually configured in your application, and never publish real administrator credentials.

## 🗂️ Typical Project Structure

```text
laravel-admin-dashboard/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   └── Admin/
│   │   └── Middleware/
│   └── Models/
├── bootstrap/
│   └── app.php
├── config/
├── database/
│   ├── migrations/
│   └── seeders/
├── public/
├── resources/
│   └── views/
│       └── admin/
├── routes/
│   ├── web.php
│   └── admin.php
├── storage/
├── tests/
├── .env.example
├── .gitignore
├── artisan
├── composer.json
├── package.json
└── README.md
```

This is a typical Laravel structure; exact folders may differ depending on the implementation.

## 🧪 Troubleshooting

**Database connection error**
- Verify the MySQL service is running.
- Check the database credentials in `.env`.
- Confirm the database exists.

**Application key missing**
```bash
php artisan key:generate
```

**Route or configuration changes not appearing**
```bash
php artisan optimize:clear
php artisan route:list
```

**Frontend assets missing**
```bash
npm install
npm run build
```

**Permission denied**
- Check the authenticated admin's assigned roles and permissions.
- Verify the middleware aliases and route middleware configuration.
- Confirm the relevant permissions exist in the database.

## 🔒 Security Recommendations

- Never commit `.env` or production credentials.
- Keep `.env.example` free of secrets.
- Validate all incoming requests.
- Enforce authorization on the server.
- Protect privileged roles from unauthorized modification.
- Use HTTPS in production.
- Disable debug mode in production.
- Add automated tests for authentication and permissions.
- Avoid publishing real customer data or production database backups.

## 📌 Future Enhancements

- Dashboard analytics and charts.
- Activity logs and audit trails.
- Email notifications.
- Password reset functionality.
- Search, filters, and pagination.
- CSV/Excel exports.
- Automated feature tests.
- REST API integration using Laravel Sanctum, if required.

## 👨‍💻 Developer

**Adarsh Pal**  
Laravel Developer | PHP | MySQL | React.js | REST APIs

- **GitHub:** https://github.com/adashhytrix
- **Portfolio:** https://adashhytrix.github.io/portfolio/
- **Website:** https://adarshdev.tech

## 📄 License

This project uses Laravel. The license for this specific application should be stated according to the license you choose for your own code. Laravel's framework license does not automatically determine the license of your entire application.