# 🚀 Premium B2B & B2C Ecommerce Fullstack Platform

A high-performance, professional e-commerce solution built with **Laravel 12**, **Blade**, and **Modern JavaScript**. This platform features a stunning UI, advanced filtering systems, and a comprehensive B2B sourcing engine.

---

## 🌟 Key Features

### 🛒 Customer & B2B Experience
- **B2B Bulk Sourcing System**: Integrated "Request Bulk Quotation" engine on product pages and home page. Features collapsible forms and negotiation tracking.
- **Dynamic Product Discovery**: Products are **fully database-driven**. Search and filter by category, brand, price range, and ratings with AJAX-powered updates.
- **Multi-Currency System**: Automatic currency normalization using `CurrencyService` (USD, AED, PKR, etc.) with real-time conversion symbols.
- **Stripe & COD Integration**: Seamless checkout flow for both retail and bulk orders.
- **Smart Search**: Context-aware search functionality that scans names, tags, and categories.
- **Review System**: User-driven product ratings and reviews with media support and verified purchase badges.
- **Responsive Design**: Fully optimized for mobile, tablet, and desktop viewing.

### 🛡️ Administrative Dashboard
- **Bulk Inquiry Management**: Dedicated admin panel to manage supplier inquiries, update statuses, and negotiate prices. Includes professional delete confirmation modals.
- **Inventory Management**: Complete CRUD operations for products, categories, and brands.
- **Status Toggles**: Instantly activate or deactivate products from the grid view using AJAX.
- **Lightweight CMS**: Control landing assets (Navbar Branding, Hero Text, Footer App Links) directly from the settings.
- **Professional Analytics**: Visual summary of total products, inquiries, and low-stock alerts.

---

## 🛠️ Tech Stack & Requirements

- **Backend**: Laravel 12 (PHP 8.2+)
- **Frontend**: Blade Templating, Vanilla CSS (Premium Custom Styles), Modern JS
- **Database**: MySQL (Required)
- **Local Server**: **XAMPP / WAMP** (Ensure Apache & MySQL are running)
- **Payments**: Stripe API

---

## 🔑 Security & Authentication

The platform features **Dual Registration Tracks**:
1. **User Registration**: Standard checkout and profile access for retail customers.
2. **Admin Registration**: Secure signup for staff. Requires a specific security key.

> [!IMPORTANT]
> **Admin Security Key:** `MyStore@2026`  
> *This key is required during the Admin registration process to grant administrative privileges.*

---

## 🚀 Installation Guide

### 1. Prerequisite
Ensure you have **XAMPP** installed. Open XAMPP Control Panel and start **Apache** and **MySQL**.

### 2. Clone the Repository
```bash
git clone https://github.com/your-username/Ecommerce-fullstack-design.git
cd Ecommerce-fullstack-design
```

### 3. Install Dependencies
```bash
composer install
npm install
```

### 4. Environment Setup
1. Copy `.env.example` to `.env`.
2. Generate app key: `php artisan key:generate`.
3. Create a database in phpMyAdmin (e.g., `ecommerce_db`).
4. Update `.env` with your DB credentials:
   ```env
   DB_DATABASE=ecommerce_db
   DB_USERNAME=root
   DB_PASSWORD=
   ```

### 5. Database Migration & Seeding
```bash
php artisan migrate --seed
```

### 6. Start Server
```bash
php artisan serve
```
Visit `http://127.0.0.1:8000` in your browser.

---
## 🎥 Project Demo Video (Must Watch)
👉 **[Watch Demo Video on Google Drive](https://drive.google.com/file/d/17czdPEdEdxaZdKct4tKSfLmiWvdikE7b/view?usp=sharing)**
---

## 📸 Project Structure

```text
├── app/
│   ├── Http/Controllers/       # Core business logic (Inquiry, Order, Admin)
│   ├── Models/                 # Database schemas (Product, Inquiry, Order)
│   ├── Services/               # Shared logic (CurrencyService)
├── resources/
│   ├── views/                  # UI Templates (Blade)
│   ├── css/                    # Custom design system
├── public/
│   ├── Images/                 # Static assets & product images
├── routes/                     # Web endpoints (Auth, Admin, B2B)
```

---

## 📝 Professional Standards
- **Relational Integrity**: No hardcoded products; all data is fetched from the MySQL database.
- **AJAX Driven**: Real-time filters and status updates for a "Single Page App" feel.
- **Mobile First**: Optimized touch targets and responsive grid systems.

---

## 📄 License
This project is open-sourced software licensed under the [MIT license](LICENSE).
