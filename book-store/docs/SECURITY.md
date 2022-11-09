# Security Documentation

## Overview

This document outlines the security measures implemented in BookHaven to protect user data and system integrity.

## Authentication & Authorization

### User Authentication
```mermaid
sequenceDiagram
    participant User
    participant Frontend
    participant Backend
    participant Database
    
    User->>Frontend: Login Request
    Frontend->>Backend: Validate Credentials
    Backend->>Database: Verify User
