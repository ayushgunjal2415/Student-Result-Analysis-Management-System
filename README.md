# 🎓 Student Result Analysis & Management System

![PHP](https://img.shields.io/badge/PHP-8.x-blue?style=for-the-badge&logo=php)
![MySQL](https://img.shields.io/badge/MySQL-Database-orange?style=for-the-badge&logo=mysql)
![Bootstrap](https://img.shields.io/badge/Bootstrap-5-purple?style=for-the-badge&logo=bootstrap)
![JavaScript](https://img.shields.io/badge/JavaScript-Frontend-yellow?style=for-the-badge&logo=javascript)
![XAMPP](https://img.shields.io/badge/XAMPP-Localhost-red?style=for-the-badge&logo=xampp)
![Status](https://img.shields.io/badge/Status-Completed-success?style=for-the-badge)

---

# 📌 Project Overview

The **Student Result Analysis & Management System** is a web-based academic management application developed using **PHP, MySQL, Bootstrap, HTML, CSS, and JavaScript**.

This system allows administrators to efficiently manage student academic records through a modern dashboard interface.

The project includes:
- Student result management
- Authentication system
- Dashboard analytics
- Search and filtering
- Sorting functionality
- Dynamic grade generation
- Responsive UI

The system is designed for educational institutions to simplify storing, updating, analyzing, and managing student results.

---

# 🚀 Features

# 🔐 Authentication Module
- Admin Signup
- Secure Login System
- Session Management
- Logout Functionality

---

# 📊 Dashboard Analytics
- Total Students Counter
- Average Marks Calculation
- Topper Information Display
- Responsive Dashboard Cards

---

# 📋 Student Result Management
- Add Student Result
- Edit Existing Records
- Delete Student Records
- Dynamic Grade Generation
- Grade Badge System

---

# 🔍 Search / Filter / Sort System
- Search by Student Name
- Search by Subject
- Filter by Subject
- Sort by Highest Marks
- Sort by Lowest Marks

---

# 🎨 User Interface Features
- Bootstrap 5 Responsive Design
- Modern Dashboard Layout
- Background Image UI
- Professional Cards & Tables
- Colorful Grade Badges
- Responsive Forms

---

# 📄 PDF Export Feature
The project also supports:
- Exporting student result data into PDF format
- Printable academic records
- Easy sharing of result reports

---

# 🛠️ Technologies Used

| Technology | Purpose |
|---|---|
| PHP | Backend Development |
| MySQL | Database Management |
| HTML5 | Web Structure |
| CSS3 | Styling |
| Bootstrap 5 | Responsive UI |
| JavaScript | Dynamic Functionality |
| XAMPP | Local Server Environment |

---

# 🧱 System Architecture

```text
                ┌─────────────────────┐
                │     User/Admin      │
                └─────────┬───────────┘
                          │
                          ▼
                ┌─────────────────────┐
                │   Frontend Layer    │
                │ HTML/CSS/Bootstrap  │
                │     JavaScript      │
                └─────────┬───────────┘
                          │
                          ▼
                ┌─────────────────────┐
                │    PHP Backend      │
                │ Authentication      │
                │ CRUD Operations     │
                │ Search & Filter     │
                │ Grade Management    │
                └─────────┬───────────┘
                          │
                          ▼
                ┌─────────────────────┐
                │     MySQL DB        │
                │ students table      │
                │ users table         │
                └─────────────────────┘
```

---

# 📂 Project Structure

```text
result-management/
│
├── login.php
├── signup.php
├── logout.php
├── index.php
├── form.html
├── process.php
├── edit.php
├── update.php
├── delete.php
├── db.php
├── style.css
├── generate_pdf.php
├── bg.jpg
├── form-bg.jpg
```

---

# 🗄️ Database Structure

# Database Name

```sql
result_db
```

---

# Students Table

```sql
CREATE TABLE students (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    subject VARCHAR(100) NOT NULL,
    marks INT NOT NULL,
    grade VARCHAR(10) NOT NULL
);
```

---

# Users Table

```sql
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(100),
    password VARCHAR(255)
);
```

---

# 🧮 Grade Generation Logic

| Marks Range | Grade |
|---|---|
| 90+ | O |
| 80 - 89 | A+ |
| 70 - 79 | A |
| 60 - 69 | B |
| 50 - 59 | C |
| 35 - 49 | D |
| Below 35 | F |

---

# ⚙️ Installation Guide

# 1️⃣ Clone Repository

```bash
git clone https://github.com/your-username/result-management-system.git
```

---

# 2️⃣ Move Project

Move project folder to:

```text
xampp/htdocs/
```

---

# 3️⃣ Start XAMPP

Start:
- Apache
- MySQL

---

# 4️⃣ Open phpMyAdmin

```text
http://localhost/phpmyadmin
```

---

# 5️⃣ Create Database

```sql
CREATE DATABASE result_db;
```

---

# 6️⃣ Create Tables

Run the SQL queries provided above.

---

# 7️⃣ Run Project

```text
http://localhost/result-management/
```

---

# 📸 Screenshots

## Dashboard
- Dashboard Cards
- Student Table
- Search & Filter System
<img width="1910" height="1448" alt="screencapture-localhost-result-management-index-php-2026-05-26-21_07_20" src="https://github.com/user-attachments/assets/405cd62a-7975-4419-bf04-8010cedc911f" />



## Add Result Form
- Dynamic Grade Generation
- Subject Dropdown
<img width="1910" height="1035" alt="screencapture-localhost-result-management-form-html-2026-05-23-21_30_29" src="https://github.com/user-attachments/assets/48ceca2c-a702-42eb-be1c-b0c344c13dca" />


## Authentication
- Login Page
- Signup Page
<img width="1910" height="1035" alt="screencapture-localhost-result-management-login-php-2026-05-23-21_30_58" src="https://github.com/user-attachments/assets/208797cb-b97a-4460-abd5-d90db130e631" />


---

# 🔥 Key Functionalities

## CRUD Operations
- Create Student Result
- Read Student Records
- Update Student Information
- Delete Student Data

---

## Dynamic Query System
The dashboard supports:
- Search Queries
- Subject Filtering
- Dynamic Sorting
- Real-Time Result Display

---

# 💡 Learning Outcomes

This project helped in understanding:
- PHP & MySQL Integration
- CRUD Operations
- Session Management
- Dynamic SQL Queries
- Dashboard UI Design
- Bootstrap Grid System
- Search & Filter Logic
- Form Handling
- Authentication System

---

# 👨‍💻 Author

# Ayush Gunjal

---

# 📄 License

This project is developed for educational and learning purposes.
