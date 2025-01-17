<?php
require_once 'Database.php';
require_once 'User.php';
class Learner {

    public function showLearners() {
        $db = Database::getInstance()->getConnection();
        $query = "SELECT id_user, first_name, last_name, email, password, id_role, status 
                  FROM user 
                  WHERE id_role = 3"; 
        $stmt = $db->prepare($query);
        $stmt->execute();      
        $users = []; 
    
        while ($userData = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $users[] = $userData; 
        }
    
        return $users;
    }

    public function deleteLearner($id_user) {
        $db = Database::getInstance()->getConnection();
        $query = "DELETE FROM user WHERE id_user = :id_user"; 
        $stmt = $db->prepare($query);
        $stmt->bindParam(':id_user', $id_user, PDO::PARAM_INT);
        return $stmt->execute();
    }

    public function activateLearner($id_user) {
        $db = Database::getInstance()->getConnection();
        $query = "UPDATE user SET status = 'activated' WHERE id_user = :id_user";
        $stmt = $db->prepare($query);
        $stmt->bindParam(':id_user', $id_user, PDO::PARAM_INT);
        return $stmt->execute(); 
    }

    public function deactivateLearner($id_user) {
        $db = Database::getInstance()->getConnection();
        $query = "UPDATE user SET status = 'suspended' WHERE id_user = :id_user";
        $stmt = $db->prepare($query);
        $stmt->bindParam(':id_user', $id_user, PDO::PARAM_INT);
        return $stmt->execute();
    }



   
    
}