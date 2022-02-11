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
- `POST /api/user/reading-log` — Add/update reading log
- `GET /api/user/wishlist` — Get wishlist
- `POST /api/user/wishlist` — Add to wishlist

## Quiz & Games
- `GET /api/quizzes/{book_id}` — Get quizzes for a book
- `POST /api/quizzes/{quiz_id}/submit` — Submit quiz answers
- `GET /api/user/quiz-results` — Get user’s quiz results

## Orders & Payments
- `POST /api/orders` — Create order
- `GET /api/orders` — List user orders
- `GET /api/orders/{id}` — Order details
- `POST /api/payments/stripe` — Process Stripe payment
- `POST /api/payments/paypal` — Process PayPal payment

## Admin
- `GET /api/admin/reports` — Get analytics reports
- `POST /api/admin/books` — Add/edit book
