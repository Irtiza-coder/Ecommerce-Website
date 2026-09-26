# Crest & Clove — E-Commerce Web Application

A full-featured, responsive e-commerce web application developed with **Laravel**, **MySQL**, **Blade**, and **JavaScript**.

---

## 📌 Project Overview
**Crest & Clove** is an online kitchenware and home artisan store featuring a customer-facing storefront and a back-office administration panel.

### Key Features
- **Storefront & Catalog**:
  - Dynamic homepage with CMS-managed banners, collections, and featured products.
  - Category-based product browsing and live search.
  - Product details page with real-time stock availability and quantity selector.
  - Customer wishlist and shopping cart management.
  - Checkout system with order summary, shipping calculation, and order placement.
  - Customer dashboard with order history, itemized receipts, and printable invoices.
  - Contact Us inquiry submission form.
- **Admin Control Panel**:
  - Business analytics and sales metrics overview.
  - Product Catalog Management (Create, Edit, Delete, Stock control, Image upload).
  - Order Processing & status updates (Pending, Processing, Completed, Cancelled).
  - Customer Management (Registered users list, order count, lifetime spend).
  - Contact Inquiries Inbox with quick reply.
  - Homepage CMS & Testimonials management.

---

## ⚙️ Tech Stack & Requirements
- **Framework**: Laravel 11
- **Backend**: PHP 8.2+
- **Database**: MySQL
- **Frontend**: Blade Templating, Vanilla CSS, JavaScript, Bootstrap 5

---

## 🚀 Getting Started & Installation

### 1. Prerequisites
Ensure you have **PHP (>= 8.2)**, **Composer**, and **MySQL** (e.g. via XAMPP) installed on your system.

### 2. Database Setup
1. Start Apache and MySQL in XAMPP.
2. Open phpMyAdmin (`http://localhost/phpmyadmin`) or MySQL CLI and create a new database:
   ```sql
   CREATE DATABASE ecommerce;
   ```

### 3. Environment Configuration
Ensure your `.env` file matches your local database settings:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=ecommerce
DB_USERNAME=root
DB_PASSWORD=
```

### 4. Run Migrations
Run the database migrations:
```bash
php artisan migrate
```

### 5. Start the Application
Run the local development server:
```bash
php artisan serve
```

Visit the application at:
- **Storefront**: [http://127.0.0.1:8000](http://127.0.0.1:8000)
- **Admin Portal**: [http://127.0.0.1:8000/admin/login](http://127.0.0.1:8000/admin/login)

---

## 🔐 Admin Credentials

| Role | Username | Password | Login URL |
| :--- | :--- | :--- | :--- |
| **Administrator** | `admin` | `123456` | `http://127.0.0.1:8000/admin/login` |
