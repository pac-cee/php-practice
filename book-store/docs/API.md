# API Documentation

## Overview

BookHaven's API provides programmatic access to book catalog, user management, and order processing functionalities. This document details the available endpoints, request/response formats, and authentication requirements.

## Authentication

All API requests require authentication using Bearer tokens:

```http
Authorization: Bearer <token>
```

## Endpoints

### Books

#### List Books
