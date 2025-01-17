<?php
require_once 'Database.php';
require_once 'User.php';


    class Tutor {
        public function showTutors() {
            $db = Database::getInstance()->getConnection();
            $query = "SELECT id_user, first_name, last_name, email, password, id_role, status 
                      FROM user 
                      WHERE id_role = 2 AND status != 'awaiting'"; 
            $stmt = $db->prepare($query);
            $stmt->execute();      
            $users = []; 
        
            while ($userData = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $users[] = $userData; 
            }
        
            return $users;
        }

        public function approveTutor() {
            $db = Database::getInstance()->getConnection();
            $query = "SELECT id_user, first_name, last_name, email, password, id_role, status 
                      FROM user 
                      WHERE id_role = 2 AND status = 'awaiting'"; 
            $stmt = $db->prepare($query);
            $stmt->execute();      
            $users = []; 
        
            while ($userData = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $users[] = $userData; 
            }
        
            return $users;
        }

        public function deleteTutor($id_user) {
            $db = Database::getInstance()->getConnection();
            $query = "DELETE FROM user WHERE id_user = :id_user"; 
            $stmt = $db->prepare($query);
            $stmt->bindParam(':id_user', $id_user, PDO::PARAM_INT);
            return $stmt->execute();
        }

        public function activateTutor($id_user) {
            $db = Database::getInstance()->getConnection();
            $query = "UPDATE user SET status = 'activated' WHERE id_user = :id_user";
            $stmt = $db->prepare($query);
            $stmt->bindParam(':id_user', $id_user, PDO::PARAM_INT);
            return $stmt->execute(); 
        }

        public function deactivateTutor($id_user) {
            $db = Database::getInstance()->getConnection();
            $query = "UPDATE user SET status = 'suspended' WHERE id_user = :id_user";
            $stmt = $db->prepare($query);
            $stmt->bindParam(':id_user', $id_user, PDO::PARAM_INT);
            return $stmt->execute();
        }
    }
    
