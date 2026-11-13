# Msaidizi Diaspora

The Msaidizi Diaspora web application helps Kenyans living abroad arrange trusted, on-the-ground services for their families, property, projects, and other needs in Kenya.

- **Live website:** [msaidizidiaspora.co.ke](https://msaidizidiaspora.co.ke/)
- **This repository:** React frontend and Laravel API source
- **Layout:** frontend at the repository root; backend in `backend/diaspora-help-backend/`

## Contents

- [Features](#features)
- [Application routes](#application-routes)
- [Technology](#technology)
- [Requirements](#requirements)
- [Run locally](#run-locally)
- [Environment configuration](#environment-configuration)
- [Available commands](#available-commands)
- [How the application works](#how-the-application-works)
- [Repository structure](#repository-structure)
- [Production deployment](#production-deployment)
- [Data and secrets](#data-and-secrets)
- [Attribution](#attribution)
- [Troubleshooting](#troubleshooting)

## Features

- Responsive homepage with a welcome carousel and API-driven service categories.
- Service search, category browsing, and service detail pages.
- Dedicated information pages for Building & Consultancy, Land & Property, Family Errands, Government Services, and Investment.
- User sign-up, sign-in, account details, and request history.
- Service-request submission and request status updates.
- Admin sign-in, request management, and category/subcategory management.
- Shared branding and service imagery, including the Events Planning image.

## Application routes

| Route | Purpose |
| --- | --- |
| `/` | Homepage, featured services, categories, and testimonials |
| `/services` | Search and browse services |
| `/services/:categoryId` | View a category and request a service |
| `/how-it-works` | Explain the service-request process |
| `/investment` | Investment information |
| `/building-consultancy` | Building and consultancy information |
| `/land-property-purchase` | Land and property services |
| `/family-errands-concierge` | Family errands and concierge services |
| `/government-services` | Government services information |
| `/login` and `/register` | User sign-in and registration |
| `/account` and `/requests` | Account details and requests |
| `/admin/login` | Administrator sign-in |
| `/admin/dashboard` | Admin request dashboard |
| `/admin/categories` | Admin category and subcategory management |

## Technology

### Frontend

- React 19 and TypeScript
- Vite 8
- React Router 7
- Tailwind CSS 4
- Axios, Lucide React, and Sonner
- Oxlint

### Backend

- Laravel 13 and PHP
- Laravel Sanctum for API authentication
- SQLite for local development; configure the production database on the server
- Composer for PHP dependencies

## Requirements

- Node.js `^20.19.0` or `>=22.12.0`
- npm
- PHP 8.4.1 or later recommended for the current backend dependency set
- Composer
- A database for the backend (SQLite is used for local development)

## Run locally

Start the backend first.

### 1. Configure and run the backend

```powershell
cd backend/diaspora-help-backend
composer install
Copy-Item .env.example .env
New-Item -ItemType File -Force database/database.sqlite
php artisan key:generate
php artisan migrate --seed
php artisan serve --host=127.0.0.1 --port=8000
```

For macOS/Linux, use `cp .env.example .env` and `touch database/database.sqlite` in place of the two PowerShell file commands.

### 2. Configure and run the frontend

In a second terminal, from the repository root:

```powershell
npm ci
Set-Content .env.local 'VITE_API_URL=http://localhost:8000/api'
npm run dev
```

Open the local URL printed by Vite. The API must allow requests from the frontend origin through its CORS configuration.

> **Database data:** migrations create the schema and the included seeder adds the public Events Planning, Tours & Travel, and Car Hire categories. The live SQLite database, user accounts, service requests, and uploaded images are not included.

## Environment configuration

The frontend reads the API base URL from `VITE_API_URL`. Its Axios client appends endpoint paths such as `/fetch-categories`, `/sign-in`, and `/submit-request`.

- For local development, set `VITE_API_URL` in the root `.env.local`.
- For a production frontend build, set the production API URL in `.env.production` before running the build.
- Configure backend settings in `backend/diaspora-help-backend/.env`; use `.env.example` as the template.

**Never put passwords, API keys, or other secrets in `VITE_*` variables.** Vite embeds them in browser-delivered code. Keep the backend `.env`, database credentials, and application key on the server and out of Git.

## Available commands

Run frontend commands from the repository root:

| Command | Description |
| --- | --- |
| `npm ci` | Install frontend dependencies from the lockfile |
| `npm run dev` | Start the Vite development server |
| `npm run build` | Type-check and create the frontend build in `dist/` |
| `npm run preview` | Preview the production frontend locally |
| `npm run lint` | Run Oxlint |

Run backend commands from `backend/diaspora-help-backend/`:

| Command | Description |
| --- | --- |
| `composer install` | Install PHP dependencies |
| `php artisan migrate` | Apply database migrations |
| `php artisan db:seed` | Seed the public service categories |
| `php artisan serve` | Start Laravel's local development server |
| `composer test` | Run the Laravel test suite |

## How the application works

`src/App.tsx` defines the frontend routes. `src/apiservices/Api_client.tsx` creates the shared Axios client, reads `VITE_API_URL`, and attaches the user's authentication token to API requests. Service categories and their service lists are fetched from Laravel; the Events Planning category uses a bundled frontend image override.

The backend exposes API operations for:

- Fetching and managing service categories and subcategories.
- User registration, authentication, and account updates.
- Submitting and managing service requests.
- Admin request and category management.

## Repository structure

| Path | Contents |
| --- | --- |
| `src/apiservices/` | Frontend API client and service functions |
| `src/assets/` | Bundled brand and service images |
| `src/data/` | Static frontend data |
| `src/formtypes/` | TypeScript API and form types |
| `src/layouts/` | Shared public and admin layouts |
| `src/pages/` | Frontend pages and UI components |
| `src/utils/` | Shared frontend utilities |
| `public/` | Static files copied to the frontend build |
| `backend/diaspora-help-backend/` | Laravel API, migrations, tests, and configuration templates |

## Production deployment

Deploy the frontend and API as separate services, even though their source is stored in this repository.

### Frontend (cPanel or static hosting)

1. Set the production `VITE_API_URL`.
2. From the repository root, run `npm ci` and `npm run build`.
3. Back up the current site files.
4. Upload the **contents** of `dist/` to the domain's document root (the directory containing `index.html`). Do not upload `dist/` as a nested folder.
5. Keep existing server configuration such as `.htaccess` unless intentionally changing it.
6. Configure the web server to serve `index.html` for SPA routes such as `/services` and `/login`, so direct visits and refreshes work.
7. Hard-refresh the site and check the homepage, service pages, sign-in, and API-backed category loading.

The current Vite configuration assumes the frontend is served from the domain root. Deploying under a subdirectory requires configuring Vite's `base` path and rebuilding.

### Backend (PHP hosting)

- Deploy `backend/diaspora-help-backend/` to a PHP-capable host.
- Point the API web root to the backend's `public/` directory; do not expose the backend project root or `.env`.
- Install production Composer dependencies, configure the production database and `APP_KEY`, and allow the frontend origin in CORS.
- Back up the production database before applying migrations. Do not copy the local SQLite database to production.

## Data and secrets

The repository contains application source, migrations, and seed data for public service categories—not live accounts, service requests, uploaded images, or the local SQLite database. Generated dependencies such as `node_modules/` and `vendor/` are also excluded. Keep production credentials and private user data out of commits.

## Attribution

The frontend source was previously maintained at [munaxdev/diaspora-connect](https://github.com/munaxdev/diaspora-connect) and is included here with permission.

The backend source was previously maintained as a separate project at [munaxdev/diaspora-help-backend](https://github.com/munaxdev/diaspora-help-backend) and is included here with permission. Preserve any source notices or attribution required by the original maintainer. A project-wide `LICENSE` file has not been added.

## Troubleshooting

| Symptom | Check |
| --- | --- |
| Categories or services do not load | Confirm Laravel is running, `VITE_API_URL` is correct, the database has category data, and CORS allows the frontend origin. |
| API requests go to the wrong host | Check the environment file for the current mode and rebuild after changing it. |
| A nested frontend route returns 404 on refresh | Configure the web server's SPA fallback to `index.html`. |
| Updated images or branding do not appear | Confirm the latest `dist/` contents were uploaded and hard-refresh to bypass cached files. |
