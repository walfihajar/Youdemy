<?php
require_once './Database.php';
require_once './User.php';


class Tutor extends User implements Registering {
    // Constructor
    public function __construct($id_user, $first_name, $last_name, $email, $password, $id_role) {
        parent::__construct($id_user, $first_name, $last_name, $email, $password, $id_role);
    }

    // Register method for teachers
    public function register($first_name, $last_name, $email, $password, $id_role) {
        // Validate email format
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new Exception("Invalid email format");
        }

        // Validate password length
        if (strlen($password) < 6) {
            throw new Exception("Password must be at least 6 characters long");
        }

        // Sanitize name fields
        $first_name = htmlspecialchars($first_name);
        $last_name = htmlspecialchars($last_name);

        // Check if email already exists
        if (self::findByEmail($email)) {
            throw new Exception("Email is already registered");
        }

        // Hash the password
        $passwordHash = password_hash($password, PASSWORD_DEFAULT);

        // Insert the new teacher into the database
        $db = Database::getInstance()->getConnection();
        $stmt = $db->prepare("INSERT INTO user (first_name, last_name, email, password, id_role) VALUES (:first_name, :last_name, :email, :password, :id_role)");
        $stmt->bindParam(':first_name', $first_name, PDO::PARAM_STR);
        $stmt->bindParam(':last_name', $last_name, PDO::PARAM_STR);
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt->bindParam(':password', $passwordHash, PDO::PARAM_STR);
        $stmt->bindParam(':id_role', $this->id_role, PDO::PARAM_INT); // Use the role defined in the constructor
        $stmt->execute();
        return $stmt->execute();
    }
}