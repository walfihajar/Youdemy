<?php
require_once 'Database.php'; // Include the Database class

class Course
{
    private int $id_course;
    private string $title;
    private string $description;
    private string $picture;
    private float $price;
    private string $created_at;

    // Constructor
    public function __construct(int $id_course = 0,string $title = '',string $description = '',string $picture = '',float $price = 0.0,string $created_at = '') {
        $this->id_course = $id_course;
        $this->title = $title;
        $this->description = $description;
        $this->picture = $picture;
        $this->price = $price;
        $this->created_at = $created_at;
    }

   
    // Method to create a new course
    public function create(int $id_teacher, int $id_category): bool
    {
        $db = Database::getInstance()->getConnection();
        $stmt = $db->prepare("
            INSERT INTO course (title, description, picture, price, id_user, id_category) 
            VALUES (:title, :description, :picture, :price, :id_user, :id_category)
        ");
        $stmt->bindParam(':title', $this->title, PDO::PARAM_STR);
        $stmt->bindParam(':description', $this->description, PDO::PARAM_STR);
        $stmt->bindParam(':picture', $this->picture, PDO::PARAM_STR);
        $stmt->bindParam(':price', $this->price, PDO::PARAM_STR);
        $stmt->bindParam(':id_user', $id_teacher, PDO::PARAM_INT);
        $stmt->bindParam(':id_category', $id_category, PDO::PARAM_INT);
        return $stmt->execute();
    }

    // Method to delete a course
    public function delete(): bool
    {
        $db = Database::getInstance()->getConnection();
        $stmt = $db->prepare("DELETE FROM course WHERE id_course = :id_course");
        $stmt->bindParam(':id_course', $this->id_course, PDO::PARAM_INT);
        return $stmt->execute();
    }

    // Method to modify a course
    public function modify(): bool
    {
        $db = Database::getInstance()->getConnection();
        $stmt = $db->prepare("
            UPDATE course 
            SET title = :title, description = :description, picture = :picture, price = :price 
            WHERE id_course = :id_course
        ");
        $stmt->bindParam(':title', $this->title, PDO::PARAM_STR);
        $stmt->bindParam(':description', $this->description, PDO::PARAM_STR);
        $stmt->bindParam(':picture', $this->picture, PDO::PARAM_STR);
        $stmt->bindParam(':price', $this->price, PDO::PARAM_STR);
        $stmt->bindParam(':id_course', $this->id_course, PDO::PARAM_INT);
        return $stmt->execute();
    }

    // Method to show a course by ID
    public static function showById(int $id_course): ?Course
    {
        $db = Database::getInstance()->getConnection();
        $stmt = $db->prepare("SELECT * FROM course WHERE id_course = :id_course");
        $stmt->bindParam(':id_course', $id_course, PDO::PARAM_INT);
        $stmt->execute();
        $courseData = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($courseData) {
            return new Course(
                $courseData['id_course'],
                $courseData['title'],
                $courseData['description'],
                $courseData['picture'],
                $courseData['price'],
                $courseData['created_at']
            );
        }
        return null;
    }

    // Method to show all courses (for admin)
    public static function showAll(): array
    {
        $db = Database::getInstance()->getConnection();
        $stmt = $db->prepare("SELECT * FROM course");
        $stmt->execute();
        $courses = [];

        while ($courseData = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $courses[] = new Course(
                $courseData['id_course'],
                $courseData['title'],
                $courseData['description'],
                $courseData['picture'],
                $courseData['price'],
                $courseData['created_at']
            );
        }
        return $courses;
    }

    // Method to show courses created by a specific teacher
    public static function showByTeacher(int $id_teacher): array
    {
        $db = Database::getInstance()->getConnection();
        $stmt = $db->prepare("SELECT * FROM course WHERE id_user = :id_teacher");
        $stmt->bindParam(':id_teacher', $id_teacher, PDO::PARAM_INT);
        $stmt->execute();
        $courses = [];

        while ($courseData = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $courses[] = new Course(
                $courseData['id_course'],
                $courseData['title'],
                $courseData['description'],
                $courseData['picture'],
                $courseData['price'],
                $courseData['created_at']
            );
        }
        return $courses;
    }

    // Method to show courses a student has enrolled in
    public static function showByStudent(int $id_student): array
    {
        $db = Database::getInstance()->getConnection();
        $stmt = $db->prepare("
            SELECT c.* 
            FROM course c 
            INNER JOIN enrollement e ON c.id_course = e.id_course 
            WHERE e.id_user = :id_student
        ");
        $stmt->bindParam(':id_student', $id_student, PDO::PARAM_INT);
        $stmt->execute();
        $courses = [];

        while ($courseData = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $courses[] = new Course(
                $courseData['id_course'],
                $courseData['title'],
                $courseData['description'],
                $courseData['picture'],
                $courseData['price'],
                $courseData['created_at']
            );
        }
        return $courses;
    }

    // Method to show courses created by a teacher with additional details (category name and enrollment count)
    public static function showByTeacherWithDetails(int $id_teacher): array
    {
        $db = Database::getInstance()->getConnection();
        $stmt = $db->prepare("
            SELECT 
                c.id_course, 
                c.title, 
                c.description, 
                cat.name as category_name, 
                COUNT(e.id_user) as enrollment_count 
            FROM 
                course c 
            LEFT JOIN 
                enrollement e ON c.id_course = e.id_course 
            LEFT JOIN 
                category cat ON c.id_category = cat.id_category 
            WHERE 
                c.id_user = :id_teacher 
            GROUP BY 
                c.id_course
        ");
        $stmt->bindParam(':id_teacher', $id_teacher, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>