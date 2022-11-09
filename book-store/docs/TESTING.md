# Testing Documentation

## Overview

This document outlines the testing strategy and procedures for BookHaven.

## Testing Levels

### 1. Unit Testing

```php
// Example Unit Test
public function testBookPrice()
{
    $book = new Book();
    $book->setPrice(29.99);
    $this->assertEquals(29.99, $book->getPrice());
}
```

### 2. Integration Testing

```php
// Example Integration Test
public function testOrderCreation()
{
    $user = $this->createUser();
    $book = $this->createBook();
    $order = $this->orderService->createOrder($user, [$book]);
    $this->assertNotNull($order->getId());
}
```

### 3. End-to-End Testing

```javascript
// Example E2E Test
describe('Checkout Flow', () => {
