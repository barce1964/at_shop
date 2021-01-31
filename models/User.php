<?php

    class User {
        public static function register($name, $email, $password) {

            include_once ROOT . '/db/connect.php';
            $connect = new DB();
            $pwd = password_hash($password, PASSWORD_BCRYPT);

            $query = 'INSERT INTO at_adm_users (name_user, email_user, pwd_user) '
                . "VALUES ('$name', '$email', '$pwd')";
            
            return $connect->insertRowToDB($query);
        }
        
        /**
         * Проверяет имя: не меньше, чем 2 символа
         */
        public static function checkName($name) {
            if (strlen($name) >= 2) {
                return true;
            }
            return false;
        }
        
        /**
         * Проверяет имя: не меньше, чем 6 символов
         */
        public static function checkPassword($password) {
            if (strlen($password) >= 8) {
                return true;
            }
            return false;
        }
        
        /**
         * Проверяет email
         */
        public static function checkEmail($email) {
            if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
                return true;
            }
            return false;
        }
        
        public static function checkEmailExists($email) {
            include_once ROOT . '/db/connect.php';
            $connect = new DB();

            $query = 'SELECT COUNT(*) FROM at_adm_users WHERE email_user = ' . "'$email'";

            $result = $connect->getList($query, 5);

            if($result)
                return true;
            return false;
        }
        
    }
?>