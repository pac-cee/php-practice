# BookVerse Developer Guide

This guide provides technical details for developers contributing to BookVerse.

## Table of Contents
- Project Structure
- Setup & Installation
- Database Schema
- Running Tests
- Coding Standards
- API Overview
- Deployment

## Project Structure
See the root README for a directory overview. Main folders:
- `app/` — PHP backend (MVC)
- `resources/views/` — Blade templates
- `resources/js/` — Frontend JS
- `public/` — Public assets
- `database/` — Migrations and seeders
- `tests/` — Unit/integration tests

## Setup & Installation
1. Clone the repo.
2. Copy `.env.example` to `.env` and set credentials.
3. Run `composer install` and `npm install`.
4. Run migrations and seeders.
5. Start the dev server.

## Database Schema
See ERD in `docs/diagrams/ERD.drawio` and migrations in `database/migrations/`.

## Running Tests
- Use PHPUnit for backend tests: `vendor/bin/phpunit`
- JS tests: (add framework if used)

## Coding Standards
- PHP: PSR-12
- JS: ES6+
- CSS: BEM, Grid/Flexbox

## API Overview
See `docs/APISpec.md` for REST endpoints and usage.

## Deployment
- Deploy to Render.com using the deployment guide.
- Environment variables in `.env`.

---

For questions, contact the maintainer or open an issue.
