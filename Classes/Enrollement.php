<?php
class Enrollment {
    // Attributes
    private $id_course;
    private $id_user;
    private $enrolled_in;

    // Database connection
    private $db;

    // Constructor to initialize attributes and database connection
    public function __construct($db, $id_course = null, $id_user = null) {
        $this->db = $db;
        $this->id_course = $id_course;
        $this->id_user = $id_user;
        $this->enrolled_in = null; // Will be set when the user enrolls
    }

    // Getters and Setters (optional, but good practice)
    public function getIdCourse() {
        return $this->id_course;
    }

    public function setIdCourse($id_course) {
        $this->id_course = $id_course;
    }

    public function getIdUser() {
        return $this->id_user;
    }

    public function setIdUser($id_user) {
        $this->id_user = $id_user;
    }

    public function getEnrolledAt() {
        return $this->enrolled_in;
    }

    // Method to check if a user is enrolled in a course
    public function isUserEnrolled() {
        $query = "SELECT * FROM enrollement WHERE id_user = ? AND id_course = ?";
        $stmt = $this->db->prepare($query);
        $stmt->execute([$this->id_user, $this->id_course]);
        return $stmt->fetch(PDO::FETCH_ASSOC) !== false;
    }

    // Method to enroll a user in a course
    public function enrollUser() {
        // Check if the user is already enrolled
        if ($this->isUserEnrolled()) {
            return false; // User is already enrolled
        }

        // Insert into enrollments table
        $query = "INSERT INTO enrollement (id_course, id_user, enrolled_in) VALUES (?, ?, NOW())";
        $stmt = $this->db->prepare($query);
        $success = $stmt->execute([$this->id_course, $this->id_user]);

        if ($success) {
            // Set the enrolled_at timestamp
            $this->enrolled_in = date('Y-m-d H:i:s');
        }

        return $success;
    }

    // Method to fetch all courses a user has enrolled in
    public static function getEnrolledCourses($db, $userId) {
        $query = "
            SELECT 
                c.id_course, 
                c.title, 
                c.description, 
                c.picture, 
                c.created_at AS course_created_at, 
                u.first_name AS tutor_first_name, 
                u.last_name AS tutor_last_name, 
                e.enrolled_in 
            FROM 
                enrollement e 
            JOIN 
                courses c ON e.id_course = c.id_course 
            JOIN 
                users u ON c.id_teacher = u.id_user 
            WHERE 
                e.id_user = ?
        ";
        $stmt = $db->prepare($query);
        $stmt->execute([$userId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Method to count the total number of courses a user has enrolled in
    public static function countEnrolledCourses($db, $userId) {
        $query = "SELECT COUNT(*) AS total_courses FROM enrollement WHERE id_user = ?";
        $stmt = $db->prepare($query);
        $stmt->execute([$userId]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['total_courses'];
    }
}