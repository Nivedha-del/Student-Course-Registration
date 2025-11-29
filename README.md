# Student Course Registration System

A full-stack web application developed as part of the GUVI Web Development Project.

---

## 🛠 Tech Stack

- **Frontend:** HTML5, CSS3, Bootstrap, JavaScript, jQuery, AJAX  
- **Backend:** PHP  
- **Database:** MySQL, MongoDB  
- **Session Management:** Redis  
- **Server:** XAMPP (Apache + MySQL)

---

## 🚀 Features

- Student registration with email and password
- Login using AJAX (no page reload)
- Profile page where students can update:
  - Full Name
  - Age
  - Date of Birth
  - Contact Number
- Course registration module:
  - Select multiple courses
  - Choose semester
- Data storage:
  - MySQL → Login & Authentication
  - MongoDB → Profile & Course data
  - Redis → Active session token
- Page reload retains data using DB fetch
- Secure password hashing

---

## 📁 Folder Structure

Student-Course-Registration/
│
├── public/
│ ├── index.html
│ ├── register.html
│ ├── login.html
│ └── profile.html
│
├── assets/
│ ├── css/
│ ├── js/
│ └── php/
│ ├── config.php
│ ├── register.php
│ ├── login.php
│ ├── profile.php
│ ├── logout.php
│ └── redis.php
│
├── vendor/ (Composer Packages - MongoDB + Redis)
└── README.md

---

## 🧑‍💻 How to Run Locally

1. Move the project folder to:

C:\xampp\htdocs\

2. Start the following in **XAMPP Control Panel**:

- ✔ Apache  
- ✔ MySQL  

3. Create a MySQL database:

Database Name: student_portal
Table Name: users
Columns:
id (INT, AUTO_INCREMENT, PRIMARY KEY)
full_name (VARCHAR)
email (VARCHAR, UNIQUE)
password_hash (VARCHAR)

4. Ensure Redis is running:

redis-server

5. Install dependencies with Composer:

composer install

6. Open project in browser:

http://localhost/Student-Course-Registration/public/index.html

---

## 🧪 Testing Flow

| Step | Action | Status |
|------|--------|--------|
| 1 | Register new student | ✔ Working |
| 2 | Login using AJAX | ✔ Working |
| 3 | Update profile | ✔ Saved in DB |
| 4 | Register courses | ✔ Saved in MongoDB |
| 5 | Refresh page | ✔ Data remains |
| 6 | Logout | ✔ Redis session cleared |

---

## 📌 Project Status

- ✔ Login/Register working  
- ✔ Session handling using Redis  
- ✔ Database connection (MySQL + MongoDB)  
- ✔ AJAX profile & course updates  
- ✔ AWS Hosting (Pending)  

---

## 📎 Tools Used

- VS Code  
- XAMPP  
- Composer  
- Redis  
- MongoDB Compass  

---

## 👩‍💻 Developer

**Nivedha S**

---

