# BookVerse Diagrams

This folder contains all system diagrams for BookVerse, including prompts to help you (or other contributors) recreate or update them in diagrams.net (draw.io).

---

## 1. DFD Level 0 (Context Diagram)
**Prompt:**
- Title: BookVerse – DFD Level 0 (Context Diagram)
- Central System: BookVerse System (rectangle/process in the center)
- External Entities (ellipses around):
  - User (left)
  - School Admin (bottom left)
  - Payment Provider (top right)
  - Email Provider (bottom right)
- Data Flows (arrows):
  - User → BookVerse: Registration, Login, Book Search, Reading Log, Quizzes, Recommendations
  - BookVerse → User: Book List, Recommendations, Quiz Results, Notifications
  - School Admin ↔ BookVerse: Analytics Requests/Reports
  - BookVerse → Payment Provider: Payment Requests
  - Payment Provider → BookVerse: Payment Confirmations
  - BookVerse → Email Provider: Email Notifications (password reset, etc.)

---

## 2. DFD Level 1 (Main Modules)
**Prompt:**
- Title: BookVerse – DFD Level 1
- Central System: BookVerse (rectangle/process in the center)
- Sub-processes (rectangles inside BookVerse):
  - Authentication
  - Catalog & Search
  - Reading Tracker
  - Recommendations Engine
  - Quiz/Game Engine
  - Analytics & Reports
  - Admin Panel
  - Payment Processing
