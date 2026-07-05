# CeyCom API 🚀

An enterprise-grade, headless E-Commerce & Order Processing REST API built completely from scratch using **Pure Laravel 13** and **Redis**. 

Unlike standard CRUD tutorials, **CeyCom** is architected to showcase solutions to high-scale production challenges: handling race conditions during inventory checkout, managing heavy nested category read queries, implementing stateless custom security layers, and leveraging modern Laravel 13 features—all without relying on high-level pre-built starter kits (e.g., Breeze, Jetstream, or Spatie).

---

## 🏛️ Architectural Highlights & Laravel 13 Features

This repository serves as a practical demonstration of advanced backend engineering principles and the latest **Laravel 13** capabilities:

* **Laravel 13 Route Metadata (`->metadata()`):** Replaces heavy custom middleware by attaching permissions, caching rules, and SEO descriptors directly to route definitions (e.g., `->metadata(['permission' => 'orders.view'])`) for seamless evaluation in Form Requests and Controllers.
* **Native Database Transaction Pooling:** Fully optimized for cloud connection poolers (AWS RDS Proxy, PgBouncer, Neon) using Laravel 13's native database pooling support, preventing prepared-statement conflicts during high-traffic checkout bursts.
* **Queue Job Exception Control (`retry(): bool`):** Leverages Laravel 13's granular job retry logic to immediately fail background jobs (like invoice PDFs or email notifications) when encountering non-recoverable errors, preventing worker memory exhaustion.
* **Clean Schema Dumps (`--without-migration-data`):** Maintains a pristine database structural schema for CI/CD pipelines without cluttering DDL files with migration history records.
* **Pessimistic Inventory Locking (`Overselling Protection`):** Implements `DB::transaction()` combined with MySQL InnoDB row-level locking (`SELECT ... FOR UPDATE`) on an isolated inventory table to prevent race conditions where concurrent checkouts could reduce stock below zero.
* **O(1) Category Subtree Reads via Nested Set Model:** Replaces traditional recursive `parent_id` adjacency lists with a Nested Set model (`lft`, `rgt`, `depth`), enabling full subtree retrieval in a single range scan query indexed via `(lft, rgt)`.
* **Redis-Backed Stateless Shopping Cart:** Offloads high-frequency cart operations from MySQL to Redis using custom hash structures and strict Time-To-Live (TTL) policies.
* **Polymorphic Discount Engine:** Uses Eloquent polymorphic relations (`morphTo` / `morphMany`) to create a flexible coupon engine capable of applying rules across individual products, entire categories, or global cart totals.

---

## 🛠️ Core Tech Stack

* **Framework:** Laravel 13.x (Latest LTS-track architecture)
* **Language:** PHP 8.3+
* **Database:** MySQL 8.0+ (InnoDB Storage Engine with Native Pooling Support)
* **Caching & Queueing:** Redis via pure-PHP `predis/predis`
* **Testing:** PHPUnit / Pest Framework

---

## 📂 Architecture Enforced Directory Structure

```text
app/
├── DTOs/                 # Type-safe Data Transfer Objects for request handling
├── Enums/                # Strongly-typed system states (Order states, Roles)
├── Exceptions/
│   └── Custom/           # Standardized, globally-caught JSON API Exception handlers
├── Http/
│   ├── Controllers/      # Ultra-lean HTTP entry points (No business logic allowed)
│   └── Requests/         # Form validation, input sanitization, and route metadata checks
├── Models/               # Lean Eloquent models optimized with local scopes and strict indexing
├── Repositories/         # Explicit Data Access Layer to isolate raw/complex queries
├── Services/             # Domain Business Logic (The core engine of CeyCom)
├── StateMachines/        # Strict transitions for stateful resources (e.g., Order Lifecycle)
└── Strategies/
    ├── Payment/          # Open-Closed compliant payment processing gateway abstraction
    └── Shipping/         # Polymorphic shipping cost calculations
```

---

## 🚀 Installation & Setup

1. **Clone the Repository:**
   ```bash
   git clone https://github.com/GayangaBandara/CeyCom.git
   cd CeyCom
   ```

2. **Run the Automatic Setup Script:**
   This project includes a convenient composer setup script that installs dependencies, copies `.env`, generates the app key, runs migrations, and builds frontend assets:
   ```bash
   composer run setup
   ```
   *Alternatively, you can run the commands manually:*
   ```bash
   composer install
   cp .env.example .env
   php artisan key:generate
   php artisan migrate --force
   npm install --ignore-scripts
   npm run build
   ```

3. **Configure Environment:**
   Adjust your database, Redis, and other service credentials inside your `.env` file as needed.

---

## 🏃 Running the Application

To concurrently run the development server, queue listener, logs/pail listener, and Vite dev server, execute:
```bash
composer run dev
```

---

## 🧪 Running Tests

To execute the PHPUnit test suite:
```bash
composer run test
```

---

## License
MIT License © [GayangaBandara](https://github.com/GayangaBandara)