<?php
require_once 'Database.php'; 
require_once 'ContentText.php';
require_once 'ContentVideo.php';
class Course
{
    private ?int $id_course;
    private string $title;
    private string $description;
    private string $picture;
    private float $price;
    private string $created_at;
    private PDO $db;

    // Constructor
    public function __construct(PDO $db, ?int $id_course = null, string $title = '', string $description = '', string $picture = '', float $price = 0.0, string $created_at = '')
    {
        $this->db = $db;
        $this->id_course = $id_course;
        $this->title = $title;
        $this->description = $description;
        $this->picture = $picture;
        $this->price = $price;
        $this->created_at = $created_at;
    }


    public function getIdCourse(): ?int
    {
        return $this->id_course;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function getPicture(): string
    {
        return $this->picture;
    }

    public function getPrice(): float
    {
        return $this->price;
    }

    public function getCreatedAt(): string
    {
        return $this->created_at;
    }

    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    public function setDescription(string $description): void
    {
        $this->description = $description;
    }

    public function setPicture(string $picture): void
    {
        $this->picture = $picture;
    }

    public function setPrice(float $price): void
    {
        $this->price = $price;
    }

    public function delete(): bool
    {
        $stmt = $this->db->prepare("DELETE FROM course WHERE id_course = :id_course");
        $stmt->bindParam(':id_course', $this->id_course, PDO::PARAM_INT);
        return $stmt->execute();
    }

    public function modify(): bool
    {
        $stmt = $this->db->prepare("
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

    public function activate(): bool
    {
        $stmt = $this->db->prepare("UPDATE course SET status = 'activated' WHERE id_course = :id_course");
        $stmt->bindParam(':id_course', $this->id_course, PDO::PARAM_INT);
        return $stmt->execute();
    }


    public function deactivate(): bool
    {
        $stmt = $this->db->prepare("UPDATE course SET status = 'suspended' WHERE id_course = :id_course");
        $stmt->bindParam(':id_course', $this->id_course, PDO::PARAM_INT);
        return $stmt->execute();
    }

    public static function showById(PDO $db, int $id_course): ?Course
    {
        $stmt = $db->prepare("SELECT * FROM course WHERE id_course = :id_course");
        $stmt->bindParam(':id_course', $id_course, PDO::PARAM_INT);
        $stmt->execute();
        $courseData = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($courseData) {
            return new Course(
                $db,
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

    public static function showAll(PDO $db): array
    {
        $stmt = $db->prepare("
            SELECT c.id_course, c.title, c.price, c.created_at, c.status, c.archive, cat.name as category, u.first_name, u.last_name 
            FROM course as c 
            LEFT JOIN category as cat ON c.id_category = cat.id_category
            LEFT JOIN user u ON c.id_user = u.id_user
        ");
        $stmt->execute();
        $courses = [];

        while ($courseData = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $courses[] = $courseData;
        }

        return $courses;
    }

    public static function showByTeacher(PDO $db, int $id_teacher): array
    {
        $stmt = $db->prepare("SELECT * FROM course WHERE id_user = :id_teacher");
        $stmt->bindParam(':id_teacher', $id_teacher, PDO::PARAM_INT);
        $stmt->execute();
        $courses = [];

        while ($courseData = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $courses[] = new Course(
                $db,
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

    public static function showByStudent(PDO $db, int $id_student): array
    {
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
                $db,
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

    public static function showByTeacherWithDetails(PDO $db, int $id_teacher): array
    {
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


    public static function showInCatalogue(PDO $db, int $page = 1, int $perPage = 10, string $search = ''): array
    {
        try {
            // Calculate the offset
            $offset = ($page - 1) * $perPage;

            // Prepare the SQL query with search condition
            $sql = "
                SELECT 
                    c.id_course, 
                    c.title, 
                    c.price, 
                    c.created_at, 
                    c.status, 
                    c.archive, 
                    c.picture, 
                    cat.name AS category, 
                    u.first_name, 
                    u.last_name, 
                    COUNT(e.id_user) AS enrollment_count
                FROM 
                    course AS c
                INNER JOIN 
                    user AS u ON c.id_user = u.id_user
                LEFT JOIN 
                    category AS cat ON c.id_category = cat.id_category
                LEFT JOIN 
                    enrollement AS e ON c.id_course = e.id_course
                WHERE 
                    c.status = 'activated' AND c.archive = '0'
            ";

            if (!empty($search)) {
                $sql .= " AND (c.title LIKE :search OR c.description LIKE :search OR cat.name LIKE :search)";
            }

            $sql .= " GROUP BY c.id_course LIMIT :limit OFFSET :offset";

            $stmt = $db->prepare($sql);

            if (!empty($search)) {
                $searchTerm = "%$search%";
                $stmt->bindValue(':search', $searchTerm, PDO::PARAM_STR);
            }

            $stmt->bindValue(':limit', $perPage, PDO::PARAM_INT);
            $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);

            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Database error in showInCatalogue: " . $e->getMessage());
            return [];
        }
    }

    public static function countCourses(PDO $db, string $search = ''): int
{
    try {
        $sql = "
            SELECT COUNT(*) AS total
            FROM course
            WHERE status = 'activated' AND archive = '0'
        ";

        if (!empty($search)) {
            $sql .= " AND (title LIKE :search OR description LIKE :search)";
        }

        $stmt = $db->prepare($sql);

        if (!empty($search)) {
            $searchTerm = "%$search%";
            $stmt->bindValue(':search', $searchTerm, PDO::PARAM_STR);
        }

        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return (int) $result['total']; 
    } catch (PDOException $e) {
        error_log("Database error in countCourses: " . $e->getMessage());
        return 0;
    }
}

    public static function getCourseDetails($db, $courseId) {
        $query = "
            SELECT 
                c.*, 
                u.first_name, 
                u.last_name, 
                ct.type,
                
                ct.content_text, 
                ct.url_video 
            FROM 
                course c 
            JOIN 
                user u ON c.id_user = u.id_user 
            LEFT JOIN 
                content ct ON c.id_course = ct.id_course 
            WHERE 
                c.id_course = ?
        ";
        $stmt = $db->prepare($query);
        $stmt->execute([$courseId]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    
    public static function isUserEnrolled($db, $userId, $courseId) {
        $query = "SELECT * FROM enrollement WHERE id_user = ? AND id_course = ?";
        $stmt = $db->prepare($query);
        $stmt->execute([$userId, $courseId]);
        return $stmt->fetch(PDO::FETCH_ASSOC) !== false;
    }
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
                course c ON e.id_course = c.id_course 
            JOIN 
                user u ON c.id_user = u.id_user
            WHERE 
                e.id_user = ?
        ";
        $stmt = $db->prepare($query);
        $stmt->execute([$userId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function countEnrolledCourses($db, $userId) {
        $query = "SELECT COUNT(*) AS total_courses FROM enrollement WHERE id_user = ?";
        $stmt = $db->prepare($query);
        $stmt->execute([$userId]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['total_courses'];
    }
    public function verifyTypeCours(string $contentType, array $contentData): bool
    {
        if ($contentType === 'video') {
            $contentVideo = new ContentVideo($this->db, null, $this->id_course, 'video', $contentData['video-url']);
            return $contentVideo->add();
        } elseif ($contentType === 'text') {
            $contentText = new ContentText($this->db, null, $this->id_course, 'text', $contentData['text-content']);
            return $contentText->add();
        } else {
            return false;
        }
    }
}
?>