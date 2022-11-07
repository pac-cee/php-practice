# Data Flow Diagrams

## Context Level (Level 0)

```mermaid
graph TD
    Customer((Customer))
    Admin((Admin))
    System[BookHaven System]
  
    Customer -->|Browse/Order Books| System
    Admin -->|Manage Inventory/Orders| System
    System -->|Order Confirmation| Customer
    System -->|Reports/Analytics| Admin
```

## Level 1: Main System Processes

```mermaid
