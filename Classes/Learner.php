<?php
require_once 'Database.php';
require_once 'User.php';

class Learner extends User {
    private PDO $db; // Database connection

    // Constructor
    public function __construct(PDO $db, ?int $id_user = null, string $first_name = '', string $last_name = '', string $email = '', string $password = '', int $id_role = 3, string $status = 'activated') {
        // Call the parent constructor to initialize inherited properties
        parent::__construct($id_user, $first_name, $last_name, $email, $password, $id_role, $status);

        // Initialize the database connection
        $this->db = $db;
    }

    // Method to fetch all learners
    public static function showLearners(PDO $db): array {
        $query = "SELECT id_user, first_name, last_name, email, password, id_role, status 
                  FROM user 
                  WHERE id_role = 3"; // id_role = 3 for learners
        $stmt = $db->prepare($query);
        $stmt->execute();
        $learners = [];

        while ($learnerData = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $learners[] = new Learner(
                $db,
                $learnerData['id_user'],
                $learnerData['first_name'],
                $learnerData['last_name'],
                $learnerData['email'],
                $learnerData['password'],
                $learnerData['id_role'],
                $learnerData['status']
            );
        }

        return $learners;
    }

    // Method to delete a learner
    public function deleteLearner(): bool {
        $query = "DELETE FROM user WHERE id_user = :id_user";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id_user', $this->id_user, PDO::PARAM_INT);
        return $stmt->execute();
    }

    // Method to activate a learner
    public function activateLearner(): bool {
        $query = "UPDATE user SET status = 'activated' WHERE id_user = :id_user";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id_user', $this->id_user, PDO::PARAM_INT);
        return $stmt->execute();
    }

    // Method to deactivate a learner
    public function deactivateLearner(): bool {
        $query = "UPDATE user SET status = 'suspended' WHERE id_user = :id_user";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id_user', $this->id_user, PDO::PARAM_INT);
        return $stmt->execute();
    }
}