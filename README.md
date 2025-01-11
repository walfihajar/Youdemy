# 🎓 Youdemy - Online Learning Platform (Backend)

![PHP](https://img.shields.io/badge/PHP-777BB4?style=for-the-badge&logo=php&logoColor=white)
![MySQL](https://img.shields.io/badge/MySQL-005C84?style=for-the-badge&logo=mysql&logoColor=white)
![HTML5](https://img.shields.io/badge/HTML5-E34F26?style=for-the-badge&logo=html5&logoColor=white)
![CSS3](https://img.shields.io/badge/CSS3-1572B6?style=for-the-badge&logo=css3&logoColor=white)
![JavaScript](https://img.shields.io/badge/JavaScript-F7DF1E?style=for-the-badge&logo=javascript&logoColor=black)
![UML](https://img.shields.io/badge/UML-000000?style=for-the-badge&logo=diagramsdotnet&logoColor=white)

Youdemy is a **backend implementation** of an online learning platform built using **PHP (OOP)**, **MySQL**, and **HTML5/CSS3/JavaScript** for the frontend. The platform supports user roles (student, teacher, admin), course management, and secure authentication. This project was developed as part of a professional training program to demonstrate skills in backend development, database design, and secure web application practices.

---

## 🚀 **Features**

### **Front Office**
- **Visitors**:
  - Browse the catalog of courses with pagination.
  - Search for courses using keywords.
  - Create an account with a choice of role (Student or Teacher).

- **Students**:
  - View the course catalog and details (description, content, teacher, etc.).
  - Enroll in courses after authentication.
  - Access a "My Courses" section to view enrolled courses.

- **Teachers**:
  - Add new courses with details such as title, description, content (video or document), tags, and category.
  - Manage courses: edit, delete, and view student enrollments.
  - Access a "Statistics" section to track course performance (e.g., number of students, course popularity).

### **Back Office**
- **Admin**:
  - Validate teacher accounts.
  - Manage users: activate, suspend, or delete accounts.
  - Manage content: courses, categories, and tags.
  - Insert tags in bulk for efficiency.
  - Access global statistics:
    - Total number of courses.
    - Distribution of courses by category.
    - Top 3 teachers and most popular courses.

### **Transversal Features**
- **Polymorphism**: Applied in methods like "Add Course" and "Display Course."
- **Authentication and Authorization**: Secure routes based on user roles.
- **Access Control**: Restrict users to functionalities based on their role.
- **Many-to-Many Relationships**: Courses can have multiple tags.

---

