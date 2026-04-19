# Assignment Submission Management System (ASMS)

A secure, role-based full-stack web application for academic assignment management.

## 1. Project Overview
This project is developed as part of the DFP40443 - Full Stack Web Development course. It provides a platform for lecturers (Admins) to create assignments and for students to submit their work digitally via file uploads.

## 2. Setup & Installation

### Step 1: Database Setup
1. Open phpMyAdmin or your MySQL client.
2. Create a database named: assignment_system
3. Import the provided 'database.sql' file.

### Step 2: Project Deployment
1. Move the project folder to C:/laragon/www/ (or your local server root).
2. Create a folder named 'uploads' in the root project directory.
3. Ensure config.php matches your local database credentials:
   - Host: localhost
   - User: root
   - Password: (empty)

### Step 3: Execution
1. Start Laragon/XAMPP.
2. Navigate to http://localhost/your-project-folder/login.php

## 3. System Features
- Role-Based Access (Admin & Student)
- AJAX Live Search for assignments
- Secure Password Hashing (BCRYPT)
- File Upload Validation (PDF, DOCX, TXT)
- Prepared Statements for SQL Security

## 4. File Structure
- config.php: Database connection & Session init
- header.php / footer.php: Reusable UI components
- login.php / register.php: Auth system
- dashboard.php: Main page with AJAX search
- submit_assignment.php: File upload logic
- create_assignment.php: Admin assignment creation
- view_submission.php: Records & Download links
- logout.php: Session end

---
Created for: Politeknik Mersing - Session II 2025/2026
Course: DFP40443 FULL STACK WEB DEVELOPMENT
