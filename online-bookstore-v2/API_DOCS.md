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
