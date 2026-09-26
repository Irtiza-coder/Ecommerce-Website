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

---

## 🌐 Deploy to Render (Live Website)

This project is pre-configured for instant deployment on [Render](https://render.com) using Docker and Render's managed PostgreSQL database.

### Quick Deployment via Blueprint (Recommended):
1. Sign in to your [Render Dashboard](https://dashboard.render.com).
2. Click **New +** and choose **Blueprint**.
3. Connect your GitHub repository: `https://github.com/Irtiza-coder/Ecommerce-Website`.
4. Render will automatically read `render.yaml` and configure:
   - A **PostgreSQL database** (`ecommerce-db`)
   - A **Docker Web Service** (`crest-and-clove-ecommerce`)
5. In the **Environment Variables** prompt, supply:
   - **`APP_KEY`**: `base64:tbybCyYUlfBE/sC3/0OtGoraZWzWNsQAVXvMQEqLtkc=` (or generate your own using `php artisan key:generate --show`)
6. Click **Apply**.
   - Render builds the Docker container.
   - It automatically runs Composer, caches routes/views, runs database migrations, and seeds the default admin, categories, and products!
   - Your live website URL will be ready at: `https://crest-and-clove-ecommerce.onrender.com`

---

### Alternative Manual Deployment on Render:
1. **Create PostgreSQL Database on Render**:
   - Go to **New +** -> **PostgreSQL**.
   - Name: `ecommerce-db`, Database: `ecommerce`, User: `ecommerce_user`.
   - Copy the **Internal Database URL**.
2. **Create Web Service**:
   - Go to **New +** -> **Web Service**.
   - Connect repository `https://github.com/Irtiza-coder/Ecommerce-Website`.
   - Runtime: **Docker**.
   - Under **Environment Variables**, add:
     - `APP_NAME`: `Crest & Clove`
     - `APP_ENV`: `production`
     - `APP_DEBUG`: `false`
     - `APP_KEY`: `base64:tbybCyYUlfBE/sC3/0OtGoraZWzWNsQAVXvMQEqLtkc=`
     - `DB_CONNECTION`: `pgsql`
     - `DATABASE_URL`: *(paste the Internal Database URL from step 1)*
3. Click **Deploy Web Service**.

