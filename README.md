# BookSpace - Final Year Project

A comprehensive, full-stack E-Book platform built with PHP and MySQL, featuring a dual-dashboard system for readers and authors, complete bookshelf management, and secure user handling. Developed collaboratively as our final year graduation project (45+ commits).

## Project Overview
BookSpace is a web application designed to bridge the gap between readers and authors. It provides a customized dual-dashboard system where readers can discover books, manage personal bookshelves, rate titles, and update profiles, while authors can manage their publication listings and track platform activity.

## Team & Contributions
* Kaniz Sayyed: Developed the complete Reader Dashboard, profile photo upload logic, bookshelf management features, and overall platform navigation.
* Sneha Prajapati: Developed the Author Dashboard and associated backend book management logic.

## Key Features
* Dual Dashboards: Dedicated Reader Dashboard (built by Kaniz) and Author Dashboard (built by Sneha) for tailored user workflows.
* Bookshelf Management: Add and delete books from personal bookshelves with integrated rating features (ratings.sql).
* Profile Customization: Secure profile photo upload and management logic handled via the server.
* User & Book Management: Secure authentication handling (user_db.sql, password_resets.sql) and structured relational book/author databases (author_book.sql, bookshelf_db.sql).
* Responsive UI: Dynamic navigation built with HTML5, CSS3, and JavaScript.

## Tech Stack
* Frontend: HTML5, CSS3, JavaScript (ES6+)
* Backend: PHP, Session Handling
* Database: MySQL (Structured across 6 relational SQL schema files)
* Tools & Environment: XAMPP Local Server, Git, GitHub

## Project Structure
* api/ - API endpoint handlers and database table operations
* new/ - Main application source files and UI dashboards
* uploads/ - Directory for profile image uploads and media storage
* *.sql Files - Complete database schema files (user_db.sql, bookshelf_db.sql, author_book.sql, ratings.sql)
