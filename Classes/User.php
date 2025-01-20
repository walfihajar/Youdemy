<?php

enum STATUS : string {
    case suspended = "suspended";
    case activated = "activated";
    case awaiting = "awaiting";
}

class User {
    protected int $id_user;
    protected string $first_name;
    protected string $last_name;
    protected string $email;
    protected string $password;
    protected int $id_role;
    protected STATUS $status;

    public function __construct($id_user, $first_name, $last_name, $email, $password, $id_role, $status) {
        $this->id_user = $id_user;
        $this->first_name = $first_name;
        $this->last_name = $last_name;
        $this->email = $email;
        $this->password = $password;
        $this->id_role = $id_role;

        // Convert the string status to a STATUS enum value
        $this->status = STATUS::from($status);
    }

    public function getIdUser(): int {
        return $this->id_user;
    }

    public function getFirstName(): string {
        return $this->first_name;
    }

    public function getLastName(): string {
        return $this->last_name;
    }

    public function getEmail(): string {
        return $this->email;
    }

    public function getPassword(): string {
        return $this->password;
    }

    public function getIdRole(): int {
        return $this->id_role;
    }

    public function getStatus(): string {
        return $this->status->value;
    }

    public static function findByEmail($email) {
        $db = Database::getInstance()->getConnection();
        $stmt = $db->prepare("SELECT * FROM user WHERE email = :email");
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($result) {
            return new User(
                $result['id_user'],
                $result['first_name'],
                $result['last_name'],
                $result['email'],
                $result['password'],
                $result['id_role'],
                $result['status']
            );
        }

        return null;
    }

    public function save() {
        $db = Database::getInstance()->getConnection();
        try {
            $stmt = $db->prepare("INSERT INTO user (first_name, last_name, email, password, id_role, status) VALUES (:first_name, :last_name, :email, :password, :id_role, :status)");
            $stmt->bindParam(':first_name', $this->first_name, PDO::PARAM_STR);
            $stmt->bindParam(':last_name', $this->last_name, PDO::PARAM_STR);
            $stmt->bindParam(':email', $this->email, PDO::PARAM_STR);
            $stmt->bindParam(':password', $this->password, PDO::PARAM_STR);
            $stmt->bindParam(':id_role', $this->id_role, PDO::PARAM_INT);
            $stmt->bindParam(':status', $this->status->value, PDO::PARAM_STR); // Use enum value
            $stmt->execute();
        } catch (PDOException $e) {
            error_log("Database error: " . $e->getMessage());
            throw new Exception("An error occurred while saving the user.");
        }
    }

    public static function signin($email, $password) {
        $user = self::findByEmail($email);

        if (!$user || !password_verify($password, $user->password)) {
            throw new Exception("Invalid email or password");
        }
        session_start();
        session_regenerate_id(true);
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

        header("Location: ../Visitor/index.php");
        exit();
    }
}