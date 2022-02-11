# BookVerse API Specification

This document describes the REST API endpoints for BookVerse.

## Authentication
- `POST /api/register` — Register a new user
- `POST /api/login` — Login
- `POST /api/logout` — Logout
- `POST /api/password/reset` — Request password reset

## Catalog
- `GET /api/books` — List/search books
- `GET /api/books/{id}` — Get book details
- `GET /api/recommendations` — Get AI/mood-based recommendations

## User
- `GET /api/user` — Get current user profile
- `PUT /api/user` — Update profile
- `GET /api/user/reading-log` — Get reading log
