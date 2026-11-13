# Msaidizi Diaspora API

Laravel API for the Msaidizi Diaspora web application. For combined frontend/backend setup and deployment instructions, see the [repository README](../../README.md).

## Requirements

- PHP 8.4.1 or later is recommended for the current locked dependencies (`composer.json` declares PHP `^8.3`).
- Composer
- SQLite for local development, or a supported database configured for your environment

## Local setup

From this directory:

```powershell
composer install
Copy-Item .env.example .env
New-Item -ItemType File -Force database/database.sqlite
php artisan key:generate
php artisan migrate --seed
php artisan serve --host=127.0.0.1 --port=8000
```

For macOS/Linux, use `cp .env.example .env` and `touch database/database.sqlite` in place of the two PowerShell file commands.

The local API base URL is `http://localhost:8000/api`. Configure the frontend's `VITE_API_URL` to use that value. CORS must allow the frontend's origin.

Migrations create the database schema, and the seeder adds the public Events Planning, Tours & Travel, and Car Hire categories with their checked-in category images. The live SQLite database, user accounts, requests, and user-uploaded files are not included.

## API overview

Paths below are relative to the `/api` prefix.

| Method | Path | Purpose |
| --- | --- | --- |
| `GET` | `/fetch-categories` | List service categories |
| `POST` | `/sign-up` | Register a user |
| `POST` | `/sign-in` | Sign in a user |
| `POST` | `/admin-sign-in` | Sign in an administrator |
| `POST` | `/submit-request` | Submit a service request |
| `POST` | `/sign-out` | Sign out the authenticated user |
| `GET` | `/account` | Get the authenticated user's account |
| `PATCH` | `/update-account` | Update the account |
| `GET` | `/view-requests` | List requests for administrators |
| `POST` | `/mark-viewed` | Mark a request as viewed |
| `PATCH` | `/update-request` | Update request status and comments |
| `GET`, `POST`, `PATCH`, `DELETE` | `/view-categories`, `/add-category`, `/update-category`, `/delete-category/{id}` | Manage categories |
| `GET`, `POST`, `PATCH`, `DELETE` | `/view-sub-categories`, `/add-sub-category`, `/update-sub-category`, `/delete-sub-category/{id}` | Manage subcategories |

Authenticated routes use Laravel Sanctum. The frontend sends the bearer token with authenticated requests.

## Useful commands

| Command | Description |
| --- | --- |
| `php artisan migrate` | Apply database migrations |
| `php artisan db:seed` | Seed the public service categories |
| `php artisan route:list --path=api` | List API routes |
| `composer test` | Run the backend test suite |
| `composer install --no-dev --optimize-autoloader` | Install production dependencies |

## Deployment and security

- Set `APP_ENV=production`, `APP_DEBUG=false`, a unique `APP_KEY`, and production database credentials in the server-only `.env`.
- Point the web server's document root to this project's `public/` directory. Do not expose `.env`, `vendor/`, or the project root.
- Configure CORS for the deployed frontend origin.
- Back up the database before applying production migrations.
- Keep `.env`, database files, uploaded user data, and generated dependencies out of commits.

The backend source was previously maintained at [munaxdev/diaspora-help-backend](https://github.com/munaxdev/diaspora-help-backend) and is included in this repository with permission. Preserve any source notices or attribution required by the original maintainer.
