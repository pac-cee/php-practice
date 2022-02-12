# BookVerse Deployment Guide

This guide explains how to deploy BookVerse to Render.com (or similar cloud platforms).

## Prerequisites
- PHP 8.1+
- Composer
- Node.js & npm
- MySQL database
- Git

## Setup Steps
1. Clone the repo to your Render.com service.
2. Set up environment variables using `.env` (see `.env.example`).
3. Install PHP dependencies: `composer install`
4. Install JS dependencies: `npm install`
5. Run database migrations: `php artisan migrate --seed`
6. Build frontend assets: `npm run build`
7. Set up web service (Nginx by default on Render).
