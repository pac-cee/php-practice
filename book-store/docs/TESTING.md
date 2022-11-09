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
