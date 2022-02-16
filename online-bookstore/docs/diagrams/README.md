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
- External Entities (ellipses around):
  - User
  - School Admin
- Data Flows (arrows):
  - User ↔ Authentication: Register/Login/Logout
  - User ↔ Catalog & Search: Browse/Search Books
  - User ↔ Reading Tracker: Log Progress
  - User ↔ Recommendations Engine: Get Suggestions
  - User ↔ Quiz/Game Engine: Play Quizzes, Get Results
  - User ↔ Payment Processing: Checkout, Payment Status
  - School Admin ↔ Analytics & Reports: Request/View Reports
  - Admin Panel ↔ All Modules: Management Actions

---

## 3. ERD (Entity Relationship Diagram)
**Prompt:**
- Title: BookVerse – ERD
- Entities (rectangles, with key fields):
  - User (user_id, name, email, password, role, etc.)
  - Book (book_id, title, author_id, genre, format, etc.)
  - Author (author_id, name, bio, etc.)
  - Order (order_id, user_id, book_id, status, date, payment_id, etc.)
  - Quiz (quiz_id, book_id, title, etc.)
  - QuizResult (result_id, quiz_id, user_id, score, date, etc.)
  - Wishlist (wishlist_id, user_id, book_id, etc.)
  - School (school_id, name, address, etc.)
  - Report (report_id, school_id, type, generated_at, etc.)
- Relationships (lines/arrows):
  - User 1—* Order *—1 Book
  - User 1—* QuizResult *—1 Quiz
  - Author 1—* Book
  - School 1—* User (as students)
  - School 1—* Report
  - Book 1—* Quiz

---

