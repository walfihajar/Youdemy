<?php

enum STATUS : string {
    case suspended = "suspended";
    case activated = "activated";
    case awaiting = "awaiting";
}

class User {
    protected ?int $id_user;
    protected string $first_name;
    protected string $last_name;
    protected string $email;
    protected string $password;
    protected int $id_role;
    protected STATUS $status;

    public function __construct(
        ?int $id_user,
        string $first_name,
        string $last_name,
        string $email,
        string $password,
        int $id_role,
        string $status
    ) {
        $this->id_user = $id_user;
        $this->first_name = $first_name;
        $this->last_name = $last_name;
        $this->email = $email;
        $this->password = $password;
        $this->id_role = $id_role;
        $this->status = STATUS::from($status);
    }

    // Corrected method to return the status value
    public function getStatus(): string {
        return $this->status->value;
    }

    // Save method with password hashing and ID retrieval
    public function save() {
        $db = Database::getInstance()->getConnection();
        try {
            // Hash the password before saving it
            $hashedPassword = password_hash($this->password, PASSWORD_DEFAULT);

            $stmt = $db->prepare("INSERT INTO user (first_name, last_name, email, password, id_role, status) 
                VALUES (:first_name, :last_name, :email, :password, :id_role, :status)");
            
            $stmt->bindValue(':first_name', $this->first_name);
            $stmt->bindValue(':last_name', $this->last_name);
            $stmt->bindValue(':email', $this->email);
            $stmt->bindValue(':password', $hashedPassword);
            $stmt->bindValue(':id_role', $this->id_role, PDO::PARAM_INT);
            $stmt->bindValue(':status', $this->status->value);
            
            $stmt->execute();

            // Retrieve the last inserted ID and set it to $id_user
            $this->id_user = $db->lastInsertId();
        } catch (PDOException $e) {
            error_log("Database error: " . $e->getMessage());
            throw new Exception("An error occurred while saving the user.");
        }
    }

    // Allow getIdUser() to return null
    public function getIdUser(): ?int {
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

    public static function signin($email, $password) {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
    
        $user = self::findByEmail($email);
    
        if (!$user || !password_verify($password, $user->password)) {
            throw new Exception("Invalid email or password");
        }
    
        session_regenerate_id(true);
        $_SESSION['user'] = [
            'id_user' => $user->id_user,
            'first_name' => $user->first_name,
            'last_name' => $user->last_name,
            'email' => $user->email,
            'id_role' => $user->id_role,
            'status' => $user->getStatus(),
        ];
    
        if ($user->id_role == 2) {
            if ($user->getStatus() == STATUS::awaiting->value) {
                header('Location: ../Tutor/Awaiting.php');
                exit();
            } elseif ($user->getStatus() == STATUS::activated->value) {
                header('Location: ../Tutor/Overview.php');
                exit();
            }
        } else if ($user->id_role == 1) {
            header('Location: ../Admin/Overview.php');
        } else {
            header('Location: ../Learner/Dashboard.php');
        }
    }
    
    public static function logout() {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
    
        session_unset();
        session_destroy();
    
        header("Location: ../Visitor/index.php");
        exit();
    }
}