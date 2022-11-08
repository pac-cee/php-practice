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

