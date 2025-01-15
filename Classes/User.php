<?php
class User {
    // Properties
    protected $id_user;
    protected $first_name;
    protected $last_name;
    protected $email;
    protected $password;
    protected $id_role;

    // Constructor
    public function __construct($id_user, $first_name, $last_name, $email, $password, $id_role) {
        $this->id_user = $id_user;
        $this->first_name = $first_name;
        $this->last_name = $last_name;
        $this->email = $email;
        $this->password = $password;
        $this->id_role = $id_role;
    }

    // Getter for id_role
    public function getIdRole() {
        return $this->id_role;
    }

    // Find user by email
    public static function findByEmail($email) {
        $db = Database::getInstance()->getConnection();
        $stmt = $db->prepare("SELECT * FROM user WHERE email = :email");
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($result) {
            return new User($result['id_user'], $result['first_name'], $result['last_name'], $result['email'], $result['password'], $result['id_role']);
        }

        return null; // User not found
    }

    // Sign in method
    public static function signin($email, $password) {
        // Step 1: Find the user by email
        $user = self::findByEmail($email);

        // Step 2: Check if the user exists and the password is correct
        if (!$user || !password_verify($password, $user->password)) {
            throw new Exception("Invalid email or password");
        }

        // Step 3: Start a session and store user information
        session_start();
        $_SESSION['user'] = [
            'id_user' => $user->id_user,
            'first_name' => $user->first_name,
            'last_name' => $user->last_name,
            'email' => $user->email,
            'id_role' => $user->id_role,
        ];

        return $user; // Successful login
    }

    public static function logout() {
        session_start(); // Start the session
        session_unset(); // Clear all session variables
        session_destroy(); // Destroy the session
    
        // Redirect to the home page
        header("Location: ../client/home.php");
        exit(); // Ensure no further code is executed
    }
}


interface Registering {
    public function register($first_name, $last_name, $email, $password, $id_role);
}





