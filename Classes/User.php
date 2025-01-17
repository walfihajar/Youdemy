<?php
class User {
    protected $id_user;
    protected $first_name;
    protected $last_name;
    protected $email;
    protected $password;
    protected $id_role;
    protected $status; // Add status property

    public function __construct($id_user, $first_name, $last_name, $email, $password, $id_role, $status = null) {
        $this->id_user = $id_user;
        $this->first_name = $first_name;
        $this->last_name = $last_name;
        $this->email = $email;
        $this->password = $password;
        $this->id_role = $id_role;
        $this->status = $status; // Initialize status
    }

    public function getIdRole() {
        return $this->id_role;
    }

    public static function findByEmail($email) {
        $db = Database::getInstance()->getConnection();
        $stmt = $db->prepare("SELECT * FROM user WHERE email = :email");
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($result) {
            return new User($result['id_user'], $result['first_name'], $result['last_name'], $result['email'], $result['password'], $result['id_role']);
        }

        return null;
    }


    public static function signin($email, $password) {
        $user = self::findByEmail($email);

        if (!$user || !password_verify($password, $user->password)) {
            throw new Exception("Invalid email or password");
        }
        session_start();
        $_SESSION['user'] = [
            'id_user' => $user->id_user,
            'first_name' => $user->first_name,
            'last_name' => $user->last_name,
            'email' => $user->email,
            'id_role' => $user->id_role,
        ];

        return $user;
    }

    public static function logout() {
        session_start();
        session_unset();
        session_destroy();

        header("Location: ../client/home.php");
        exit();
    }
}


interface Registering {
    public function register($first_name, $last_name, $email, $password, $id_role);
}





