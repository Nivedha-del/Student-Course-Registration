# Student Course Registration System

A full-stack web application built as per GUVI Web Development task.

## Tech Stack

- HTML5, CSS3, Bootstrap
- JavaScript, jQuery, AJAX
- PHP (backend)
- MySQL (database)
- XAMPP (local server)

## Features

- Student registration with email and password
- Login using jQuery AJAX (no normal form submit)
- Profile page to update personal details (age, DOB, contact)
- Course registration (choose multiple courses + semester)
- Data stored in MySQL using prepared statements
- Frontend and backend code in separate files

## Folder Structure

- `public/` – index, register, login, profile pages  
- `assets/css/` – custom styles  
- `assets/js/` – AJAX and frontend logic  
- `assets/php/` – PHP backend (config, register, login, profile)

## How to Run Locally

1. Copy project folder into `htdocs`:
   `C:\xampp\htdocs\Student-Course-Registration`
2. Start **Apache** and **MySQL** in XAMPP.
3. Create database `student_portal` and `users` table (as per project).
4. Open in browser:

   `http://localhost/Student-Course-Registration/public/index.html`

## Credits

Project done by *[Your Name]* for GUVI Web Development Internship Task.
