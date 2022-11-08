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
