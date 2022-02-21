# BookVerse — Your Universe of Stories

## Overview
BookVerse is a unified online platform for readers, schools, and authors to track reading, receive AI-powered book recommendations, play comprehension games, and access robust analytics. Designed for individuals (12+), book clubs, schools, and authors, BookVerse addresses the gaps in existing platforms by offering a centralized reading log, mood-based recommendations, integrated quizzes, and exportable analytics.

---

## Table of Contents
- [Project Plan](docs/ProjectPlan.md)
- [System Diagrams](docs/diagrams/)
- [Codebase Structure](#codebase-structure)
- [Features](#features)
- [Testing & QA](#testing--qa)
- [Documentation](docs/)

---

## Codebase Structure
```
BookVerse/
│
├── app/                # PHP backend (MVC: Controllers, Models, Views)
├── public/             # Public assets (index.php, images, css, js)
├── resources/
│   ├── views/          # HTML5 Blade templates
│   └── js/             # ES6+ JavaScript modules
├── routes/             # Route definitions
├── database/
│   ├── migrations/     # DB schema
│   └── seeders/        # Sample data
├── tests/              # PHP unit/integration tests
├── docs/               # Markdown docs, diagrams, user guide
│   └── diagrams/       # DFDs, ERD (draw.io + images)
├── .env.example        # Environment variables template
└── README.md           # This file
```

---

## Features
- Secure auth (register/login/logout, CSRF, password reset)
- Responsive, mobile-first UI (light/dark mode, animated navbar)
- Product catalog, carousel, infinite scroll, lightbox, fly-to-cart
- Cart & checkout wizard (Stripe/PayPal)
- User dashboard (orders, wishlist, profile)
- Admin panel (sales charts, CRUD, order management)
- Advanced: full-text search, recommendations, REST API
- Animations (GSAP, ripples, transitions)
- Performance & security: lazy loading, prepared statements, rate limits
- Testing: unit/integration tests, manual UI test plan

---

## Documentation
- [Project Plan](docs/ProjectPlan.md)
- [User Guide](docs/UserGuide.md)
- [Developer Guide](docs/DeveloperGuide.md)
