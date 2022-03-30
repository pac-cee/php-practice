# API Documentation: OnlineBookstore

---

## Overview
This document describes the main API endpoints for the OnlineBookstore web application. All endpoints use JSON for request and response bodies unless otherwise noted.

---

## Authentication
- **POST** `/api/register` — Register a new user
- **POST** `/api/login` — Log in and receive a session token
- **POST** `/api/logout` — Log out and invalidate session

## Books
- **GET** `/api/books` — List/search books
- **GET** `/api/books/{id}` — Get book details
- **POST** `/api/books` — (Admin/Teacher) Add a new book
- **PUT** `/api/books/{id}` — (Admin/Teacher) Update book
- **DELETE** `/api/books/{id}` — (Admin/Teacher) Delete book

## Orders
- **POST** `/api/order` — Place a book order
- **GET** `/api/orders` — List user orders

## Quizzes
- **GET** `/api/quizzes` — List quizzes
- **POST** `/api/quizzes/attempt` — Submit quiz answers
- **GET** `/api/quiz_results` — Get user's quiz results

## Recommendations
- **GET** `/api/recommendations` — Get personalized recommendations

---

## Example Request: Register
```http
POST /api/register
