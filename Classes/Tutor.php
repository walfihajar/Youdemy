<?php
require_once 'Database.php';
require_once 'User.php';

class Tutor extends User {
    private PDO $db;

    public function __construct(PDO $db, int $id_user = 0, string $first_name = '', string $last_name = '', string $email = '', string $password = '', int $id_role = 2, string $status = 'awaiting') {
        parent::__construct($id_user, $first_name, $last_name, $email, $password, $id_role, $status);
        $this->db = $db;
    }

    public static function showTutors(PDO $db): array {
        $query = "SELECT id_user, first_name, last_name, email, password, id_role, status 
                  FROM user 
                  WHERE id_role = 2 AND status != 'awaiting'";
        $stmt = $db->prepare($query);
        $stmt->execute();
        $tutors = [];

        while ($tutorData = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $tutors[] = new Tutor(
                $db,
                $tutorData['id_user'],
                $tutorData['first_name'],
                $tutorData['last_name'],
                $tutorData['email'],
                $tutorData['password'],
                $tutorData['id_role'],
                $tutorData['status']
            );
        }

        return $tutors;
    }

    public static function approveTutors(PDO $db): array {
        $query = "SELECT id_user, first_name, last_name, email, password, id_role, status 
                  FROM user 
                  WHERE id_role = 2 AND status = 'awaiting'";
        $stmt = $db->prepare($query);
        $stmt->execute();
        $tutors = [];

        while ($tutorData = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $tutors[] = new Tutor(
                $db,
                $tutorData['id_user'],
                $tutorData['first_name'],
                $tutorData['last_name'],
                $tutorData['email'],
                $tutorData['password'],
                $tutorData['id_role'],
                $tutorData['status']
            );
        }

        return $tutors;
    }

    public function delete(): bool {
        $query = "DELETE FROM user WHERE id_user = :id_user";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id_user', $this->id_user, PDO::PARAM_INT);
        return $stmt->execute();
    }

    public function activate(): bool {
        $query = "UPDATE user SET status = 'activated' WHERE id_user = :id_user";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id_user', $this->id_user, PDO::PARAM_INT);
        return $stmt->execute();
    }

    public function deactivate(): bool {
        $query = "UPDATE user SET status = 'suspended' WHERE id_user = :id_user";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id_user', $this->id_user, PDO::PARAM_INT);
        return $stmt->execute();
    }
}