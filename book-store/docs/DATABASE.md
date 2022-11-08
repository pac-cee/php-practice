# Database Schema

## Overview

BookHaven uses MySQL for data storage. This document details the database schema, relationships, and key considerations.

## Entity Relationship Diagram

```mermaid
erDiagram
    USERS ||--o{ ORDERS : places
    USERS ||--o{ ADDRESSES : has
    USERS ||--o{ PAYMENT_METHODS : has
    USERS ||--o{ REVIEWS : writes
    BOOKS ||--o{ ORDER_ITEMS : contains
    BOOKS ||--o{ REVIEWS : receives
    ORDERS ||--|{ ORDER_ITEMS : includes
    CATEGORIES ||--o{ BOOKS : categorizes

    USERS {
        int id PK
        string name
        string email
        string password
        boolean is_admin
        timestamp created_at
    }

    BOOKS {
        int id PK
        string title
        string author
        text description
        decimal price
        int category_id FK
        string isbn
        int stock
        timestamp created_at
    }

    ORDERS {
        int id PK
        int user_id FK
        decimal total
        string status
        timestamp created_at
    }

    ORDER_ITEMS {
        int id PK
        int order_id FK
        int book_id FK
        int quantity
        decimal price
    }

    CATEGORIES {
        int id PK
        string name
        string slug
        text description
    }

    REVIEWS {
        int id PK
        int user_id FK
        int book_id FK
        int rating
        text content
        timestamp created_at
    }
```

## Tables

### users
