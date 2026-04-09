# CLAUDE.md

This file provides guidance to Claude Code (claude.ai/code) when working with code in this repository.

## Project Overview

**Mbacol Communication** is a full-stack e-commerce web application built with Laravel 12, targeting Senegalese payment methods (Wave, Orange Money, Free Money, PayDunya). It sells communication-related products with an admin dashboard, customer portal, and Livewire-powered reactive components.

## Common Commands

### Development

```bash
# Start full dev environment (server + queue + logs + Vite HMR — all concurrent)
composer dev

# Or individually:
php artisan serve          # Laravel server on port 8000
npm run dev                # Vite dev server with HMR
php artisan queue:listen   # Background job processing
php artisan pail           # Log streaming
```

### Build

```bash
npm run build              # Compile and minify frontend assets (Vite + Terser)
```

### Testing

```bash
composer test              # Clears cache then runs PHPUnit (Unit + Feature suites)
php artisan test           # Run all tests directly
php artisan test --filter=TestName   # Run a single test
```

### Database

```bash
php artisan migrate                    # Run pending migrations
php artisan migrate:fresh --seed       # Reset DB and seed (CategorySeeder, ProductSeeder)
php artisan tinker                     # Interactive REPL
```

### Code Quality

```bash
./vendor/bin/pint                      # Format PHP code (Laravel Pint)
```

### First-time Setup

```bash
composer setup  # Installs deps, copies .env, generates app key, migrates, builds assets
```

## Architecture

### Stack

- **Backend:** Laravel 12 (PHP 8.2+), MVC pattern
- **Reactive UI:** Livewire 4.1 (server-side components rendered without full page reloads)
- **Frontend:** Tailwind CSS 3.1, Alpine.js 3.4.2, Vite 7
- **Database:** SQLite by default (MySQL supported via `.env`)
- **Auth:** Laravel Breeze scaffolding with custom `role` field (`admin` / `customer`)

### Routing Structure (`routes/web.php`)

| Prefix | Guard | Purpose |
|--------|-------|---------|
| (none) | public | Home, shop, product detail, contact, static pages |
| `/mon-compte/` | `auth` | Customer orders, profile, reviews |
| `/admin/` | `auth` + `IsAdmin` | Dashboard, product/order/review/client/team management |
| `/payment/paydunya/` | — | Payment return, cancel, webhook (webhook uses `api` middleware, no CSRF) |

### Key Livewire Components (`app/Livewire/`)

- **Cart** – Shopping cart state management
- **Checkout** – Multi-step checkout with payment gateway selection
- **Search** – Autocomplete product search with history tracking
- **AddToCart** – Per-product add-to-cart button

### Payment System (`app/Services/Payment/`)

Supported gateways: **PayDunya** (primary), Wave, Orange Money, Free Money, Yass, Cash on Delivery.

PayDunya webhook receives at `POST /payment/webhook/paydunya` — CSRF-exempt via `api` middleware group.

### Authorization

The `IsAdmin` middleware (`app/Http/Middleware/IsAdmin.php`) checks `Auth::user()->role === 'admin'` and aborts with 403 otherwise. All `/admin/*` routes are protected by it.

### Asset Pipeline

- **Entry CSS:** `resources/css/app.css` (Tailwind + custom scroll-reveal animations)
- **Entry JS:** `resources/js/app.js` → `bootstrap.js` (Livewire init) + `scroll-animations.js` (Intersection Observer)
- **Build output:** `public/build/` (versioned filenames for cache busting)

### SEO

- Dynamic sitemap via `GET /sitemap.xml` (Spatie Laravel Sitemap)
- Meta tags managed by `artesaos/seotools` — configured in `config/seotools.php`
- Google Analytics 4 and Google Search Console tags are in the main layout

### Testing

- Unit tests: `tests/Unit/`
- Feature tests: `tests/Feature/`
- Uses SQLite in-memory database (`phpunit.xml`)
- Seeders available: `CategorySeeder`, `ProductSeeder`
