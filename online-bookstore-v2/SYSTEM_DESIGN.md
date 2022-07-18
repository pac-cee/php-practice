# System Design: OnlineBookstore Web Application

---

## 1. Overview & Objectives
- Describe the purpose of the system and its intended users.
- State the main objectives (e.g., unified book platform, learning tools, scalability, security).

## 2. System Architecture Diagram
![System Architecture Diagram](docs/architecture_diagram.png)
*Sample: Shows user roles (Student, Teacher, Admin), Frontend (HTML/CSS/JS), Backend (PHP), Database (MySQL), and their interactions.*
- User requests flow from browser to backend, which interacts with the database and returns responses.
- Admin/teacher roles have additional access to management modules.

## 3. Component Descriptions
- **Frontend:** Technologies used, main pages/components, UI/UX principles.
- **Backend:** Technologies used, main controllers/services, authentication, business logic.
- **Database:** Schema overview, key tables, and relationships.

## 4. Data Flow Diagrams (DFD)
### Context Diagram (Sample)
| Actor        | Process            | Data Store      | Data Flow Description           |
|--------------|--------------------|-----------------|-------------------------------|
| User         | Register/Login     | Users           | Sends credentials, receives session |
| User         | Browse Catalog     | Books           | Requests book list/details         |
| User         | Place Order        | Orders          | Submits order, receives confirmation |
| User         | Take Quiz          | Quizzes         | Submits answers, receives score     |

### Level 1 DFD: Book Ordering
| Step | Description                          |
|------|--------------------------------------|
| 1    | User selects book and clicks 'Order' |
| 2    | Frontend sends order to backend      |
| 3    | Backend validates and stores order   |
| 4    | Order confirmation returned to user  |

## 5. Entity-Relationship Diagram (ERD)
| Entity      | Attributes                                      | Relationships                     |
|-------------|-------------------------------------------------|------------------------------------|
| Users       | id, username, password, email, role, ...        | 1-to-many Orders, Progress, Quizzes|
| Books       | id, title, author, price, description, ...      | 1-to-many Orders, AudioBooks, Quizzes|
| Orders      | id, user_id, book_id, order_date, ...           | Many-to-1 User, Many-to-1 Book     |
| AudioBooks  | id, book_id, audio_file, duration               | 1-to-1 Book                        |
| Quizzes     | id, book_id, questions, ...                     | Many-to-1 Book, Many-to-1 User     |
| Progress    | id, user_id, book_id, pages_read, ...           | Many-to-1 User, Many-to-1 Book     |

*For a visual ERD, see ![ERD Diagram](docs/erd_diagram.png)*

## 6. API Specifications
### Auth Endpoints
- **POST** `/api/register` — Register a user
  - Body: `{ username, password, email, role }`
  - Response: `{ success, user_id }`
- **POST** `/api/login` — Login
  - Body: `{ username, password }`
  - Response: `{ success, session_token }`

