# 🚀 Premium Ecommerce Fullstack Platform

A high-performance, professional e-commerce solution built with **Laravel 12**, **Blade**, and **Modern JavaScript**. This platform features a stunning UI, advanced filtering systems, and a comprehensive administrative dashboard.

---

## 🌟 Key Features

### 🛒 Customer Experience
- **Dynamic Product Discovery**: Search and filter products by category, brand, price range, and ratings with AJAX-powered updates.
- **Brand Showroom**: A dedicated space to explore official store brands with high-quality logos and descriptions.
- **Smart Search**: Context-aware search functionality that scans names, tags, and categories.
- **Responsive Design**: Fully optimized for mobile, tablet, and desktop viewing.
- **Review System**: User-driven product ratings and reviews with media support.
- **Hot Offers**: Real-time discount and deal tracking.

### 🛡️ Administrative Dashboard
- **Inventory Management**: Complete CRUD operations for products, categories, and brands.
- **Advanced Product Editor**: Handle multi-image galleries, attribute variations (colors, sizes), and SEO metadata.
- **Status Toggles**: Instantly activate or deactivate products from the grid view using AJAX.
- **Bulk Actions**: Efficiently manage large inventories with bulk delete and status updates.
- **Stats & Analytics**: Visual summary of total products, views, and low-stock alerts.
- **Lightweight CMS Configuration**: Control vital landing assets (Navbar Branding, Hero Text, etc.) directly from the admin settings.

### 💳 Financials & Security
- **Stripe Integration**: Secure payment processing with server-side webhook verification.
- **Automated Refund System**: Admin can initiate partial or full refunds directly via Stripe API from the Dashboard.
- **Audit-Ready Transaction Logs**: Dedicated transactions table recording Stripe Intent IDs, Currency metrics, and precise payment lifecycles.
- **Transaction Integrity**: Prevents desynchronization between payment status and order state.
- **Secure Authentication**: Robust user authentication with OTP support.

---

## 🛠️ Tech Stack

- **Backend**: Laravel 12 (PHP 8.2+)
- **Frontend**: Blade Templating, Vanilla CSS (Premium Custom Styles), Modern JS
- **Database**: MySQL / PostgreSQL
- **Payments**: Stripe API
- **Icons & UI**: FontAwesome 6+, Google Fonts (Outfit, Inter)

---

## 🚀 Installation Guide

Follow these steps to set up the project locally:

### 1. Clone the Repository
```bash
git clone https://github.com/your-username/Ecommerce-fullstack-design.git
cd Ecommerce-fullstack-design
```

### 2. Install Dependencies
```bash
composer install
npm install
```

### 3. Environment Setup
```bash
cp .env.example .env
php artisan key:generate
```
*Configure your database credentials and Stripe API keys in the `.env` file.*

### 4. Database Migration & Seeding
```bash
php artisan migrate --seed
```

### 5. Build Assets & Start Server
```bash
npm run build
php artisan serve
```

---
## 🎥 Project Demo Video (Must Watch)
👉 **[Watch Demo Video on Google Drive](https://drive.google.com/file/d/17czdPEdEdxaZdKct4tKSfLmiWvdikE7b/view?usp=sharing)**
---

## 📸 Project Structure

```text
├── app/
│   ├── Http/Controllers/       # Core business logic
│   ├── Models/                 # Database schemas & relationships
├── database/
│   ├── migrations/             # Database version control
├── resources/
│   ├── views/                  # UI Templates (Blade)
│   ├── css/                    # Custom design system
├── public/
│   ├── Images/                 # Static assets & product images
├── routes/                     # Web & API endpoints
```

---

## 📝 Professional Standards
- **Clean Code**: Fully documented controllers and views with professional English comments.
- **SEO Optimized**: Dynamic meta tags and semantic HTML for search engine performance.
- **Scalability**: Decoupled filtering and AJAX logic for high-traffic handling.

---

## 🤝 Contribution
Contributions are welcome! Please open an issue or submit a pull request for any enhancements.

## 📄 License
This project is open-sourced software licensed under the [MIT license](LICENSE).
