# OnlineBookstore Web Application

---

## 1. Cover / Title
**OnlineBookstore Web Application**

---

## 2. Introduction
The OnlineBookstore is a robust, multi-user web application designed to revolutionize the way users interact with books and learning resources online. Unlike traditional bookstores, it offers not just a platform for purchasing books, but also a rich set of digital features—such as online reading, audiobooks, quizzes, and progress tracking—making it an all-in-one solution for students, teachers, and individual readers. The application is built with a focus on usability, accessibility, and security, ensuring a seamless experience across devices.

---

## 3. Problem Statement
In the digital era, readers and learners require more than just a place to buy books. They need a platform that supports their educational journey—enabling them to read online, listen to audiobooks, test their knowledge, and monitor their progress. Existing solutions are fragmented, often requiring users to juggle multiple platforms for buying, reading, and learning. This project addresses the need for a unified, interactive, and user-friendly online bookstore that combines purchasing, reading, and learning in one place.

---

## 4. Objectives
- **Unified Experience:** Deliver a single platform for buying, reading, and learning with books.
- **User Roles:** Support different user types—students, teachers, admins, and individuals—with tailored dashboards and permissions.
- **Digital Access:** Allow users to read books online (PDF/HTML) and listen to audiobooks directly from the platform.
- **Learning Tools:** Integrate quizzes and progress tracking to encourage active learning and self-assessment.
- **Modern UI/UX:** Ensure the interface is visually appealing, responsive, and easy to navigate for all users.
- **Security:** Protect user data and privacy through strong authentication, password hashing, and secure database queries.
- **Scalability:** Structure the codebase and database for easy future expansion (e.g., more content types, analytics, social features).

---

## 5. Diagrams (Data Flow Diagrams)
**[Draw these diagrams by hand or using a tool, and insert images here when ready.]**

![data_flow_diagram](./images/data_flow_diagram.png)

## 6. Features (Detailed)

### 1. **User Registration & Login**
- **What it does:** Enables new users to sign up and existing users to securely log in to their personalized dashboard.
- **User Workflow:**
  1. User visits the registration page and fills out the form (username, password, email, and optionally selects a role).
  2. On submission, the backend validates the input, checks for existing usernames, and hashes the password before storing it in the `users` table.
  3. User can then log in with their credentials. On successful login, a session is created (`$_SESSION['user_id']` and `$_SESSION['role']`).
  4. The session persists across pages until logout or session expiration.
- **Backend Logic:**
  - Registration and login use prepared SQL statements to prevent SQL injection.
  - Passwords are hashed using PHP’s `password_hash()` and verified with `password_verify()`.
  - Sessions are securely started and destroyed on logout.
- **Integration:**
  - All protected pages check for an active session before granting access.
  - User role determines dashboard content and navigation.

### 2. **Book Catalog**
- **What it does:** Presents a visually appealing, searchable list of all available books, with options to buy, read online, or listen to audiobooks.
- **User Workflow:**
  1. User navigates to the "Book Catalog" page from the dashboard.
  2. The app queries the `books` table (LEFT JOIN with `audio_books`) to fetch all relevant book data.
  3. Each book is displayed as a card with its cover, title, author, price, description, and action buttons:
     - **Buy/Order:** Opens a purchase/order form or triggers a POST request to add the book to the user's orders.
     - **Read Online:** If the book has a `read_file`, this button opens the file in a new tab for online reading.
     - **Listen:** If there’s an `audio_file`, this button opens the audio in a player or new tab.
- **Backend Logic:**
  - Uses SQL JOINs to aggregate book and audio data efficiently.
  - Only displays action buttons if the corresponding files exist for the book.
- **Integration:**
  - Orders are linked to the user and book in the `orders` table.
  - Reading/listening actions update the `progress` table.

### 3. **User Dashboard**
- **What it does:** Serves as the personalized home page for each user, summarizing all recent activity, stats, and recommendations.
- **User Workflow:**
  1. After login, user lands on the dashboard.
  2. The dashboard displays:
     - **Navigation Bar:** Quick links to all major sections (catalog, quizzes, orders, progress, etc.).
     - **Hero Section:** Welcome message and motivational quote or insight.
     - **Stats/Insights Grid:** Shows key metrics (books read, quizzes taken, orders made, last quiz score).
     - **Recent Activity:** Lists recent orders and quiz attempts for quick access.
     - **Notifications:** Alerts for new books, quizzes, or admin messages.
     - **Recommendations:** Personalized suggestions for books and quizzes based on user activity.
     - **Currently Reading Widget:** Highlights the book the user is currently reading, with progress, last read date, and buttons to continue reading or listening if files are available.
     - **Stats Chart:** A bar graph (using Chart.js) visualizes user activity over time (e.g., books read per month).
- **Backend Logic:**
  - Aggregates data from `orders`, `progress`, `quiz_results`, and `recommendations` tables.
  - Uses session data to filter and personalize content.
- **Integration:**
  - Links to all other features (catalog, quizzes, orders, etc.) are provided for seamless navigation.
  - All dashboard CSS is embedded or imported for a cohesive look.
  - Chart.js is used for rendering interactive charts.

### 4. **Quizzes**
- **What it does:** Lets users test their knowledge with quizzes related to books.
- **How it works:**
  - Users can take quizzes from the dashboard or catalog.
  - Quiz results are saved and can be reviewed anytime.
  - Admins/teachers can create/manage quizzes and view results.
- **Technical Notes:**
  - Quizzes are linked to specific books.
  - Results are stored in the database with scores and timestamps.

### 5. **Reading Progress Tracking**
- **What it does:** Tracks and displays how much of a book a user has read.
- **How it works:**
  - Each time a user reads a book, their progress (pages read, last read date) is updated.
  - The dashboard and a dedicated progress page show summaries and details.
- **Technical Notes:**
  - Progress is stored in the `progress` table, linked to both user and book.

### 6. **Order Management**
- **What it does:** Allows users to view their past and current book orders.
- **How it works:**
  - Orders page lists all books ordered, status (pending, completed, canceled), and order dates.
  - Users can view order history from the dashboard or dedicated page.
- **Technical Notes:**
  - Orders are linked to users and books in the database.

### 7. **Audio Books**
- **What it does:** Enables users to listen to audio versions of books when available.
- **How it works:**
  - "Listen" button appears for books with an `audio_file`.
  - Clicking opens the audio in a new tab or player.
- **Technical Notes:**
  - Audio files are managed in the `audio_books` table and stored in `/audio/`.

### 8. **Recommendations**
- **What it does:** Suggests books and quizzes based on user activity and interests.
- **How it works:**
  - Dashboard shows recommended books not yet ordered and quizzes not yet taken.
  - Recommendations update as user activity changes.
- **Technical Notes:**
  - Uses simple SQL queries to exclude already ordered/taken items.

### 9. **Admin/Teacher Dashboard**
- **What it does:** Provides additional tools for teachers/admins to manage users, quizzes, and view analytics.
- **How it works:**
  - Admins/teachers see extra navigation options (e.g., School Dashboard).
  - Can view/manage students, quizzes, and results.
- **Technical Notes:**
  - Role-based access control ensures only authorized users see these features.

### 10. **Professional, Responsive UI**
- **What it does:** Ensures the app looks and works great on all devices.
- **How it works:**
  - Uses modern CSS (Flexbox, Grid), Google Fonts, FontAwesome icons, and responsive breakpoints.
  - All pages are styled for clarity and ease of use.

---

---

## 7. Database Schema (In-Depth)
The OnlineBookstore uses a normalized relational database (MySQL) to manage users, books, orders, quizzes, progress, and more. Below is a detailed description of each table and its role:

### **books**
- **Purpose:** Stores all book metadata.
- **Fields:**
  - `id`: Primary key
  - `title`, `author`, `price`, `description`, `cover_image`: Book info
  - `read_file`: (Should be added) File name for the online reading version (PDF/HTML)

### **audio_books**
- **Purpose:** Links audio files to books.
- **Fields:**
  - `id`: Primary key
  - `book_id`: Foreign key to `books`
  - `audio_file`: File name of the audio version
  - `duration`: Length in seconds

### **users**
- **Purpose:** Stores user accounts and roles.
- **Fields:**
  - `id`, `username`, `password` (hashed), `email`
