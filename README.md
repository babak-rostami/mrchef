# MrChef – Laravel Project

A recipe website built with Laravel

## 📥 Installation

Clone the project:

```bash
git clone https://github.com/babak-rostami/mrchef.git
cd mrchef
```

Install PHP dependencies:

```bash
composer install
```

Copy `.env` file:

```bash
cp .env.example .env
```

Generate the application key:

```bash
php artisan key:generate
```

Configure your database settings inside `.env`.

---

## 🗄️ Database Setup

Run migrations:

```bash
php artisan migrate
```

Run seeders:

```bash
php artisan db:seed
```

---

## 👨‍🍳 Create Admin User

To create an admin account for accessing the admin dashboard, run:

```bash
php artisan make:admin
```

You'll be asked to enter:

Enter admin email:
Enter admin password:

Admin user created

> **Note:** This command is useful after cloning the project or during initial setup.

---

## 🏃 Start the Development Server

```bash
php artisan serve
```

Your application is now available at:

```
http://127.0.0.1:8000
```

## 🤝 Contributing

Pull requests are welcome!

---
