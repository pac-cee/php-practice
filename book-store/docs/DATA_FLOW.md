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
graph TD
    subgraph Customer Processes
        BP[Book Processing]
        OP[Order Processing]
        UP[User Processing]
    end
  
    subgraph Data Stores
        Books[(Books DB)]
        Orders[(Orders DB)]
        Users[(Users DB)]
    end
  
    Customer((Customer)) -->|Search/Browse| BP
    BP -->|Book Data| Customer
    Customer -->|Place Order| OP
    OP -->|Order Status| Customer
    Customer -->|Register/Login| UP
    UP -->|User Data| Customer
  
    BP ---|Query/Update| Books
    OP ---|Create/Read| Orders
    UP ---|CRUD| Users
```

## Level 2: Book Management Flow

```mermaid
graph TD
    Search[Search Books]
    Filter[Filter Books]
    View[View Details]
    Cart[Shopping Cart]
    Books[(Books DB)]
  
    Search -->|Query| Books
    Filter -->|Filter Criteria| Books
    Books -->|Book Data| View
