<?php

    class User {
        public static function register($name, $email, $password) {

            include_once ROOT . '/db/connect.php';
            $connect = new DB();
            $pwd = crypt($password, '$6$rounds=5000$usesomesillystringforsalt$');

            $query = 'INSERT INTO at_adm_users (name_user, email_user, pwd_user) '
                . "VALUES ('$name', '$email', '$pwd')";
            
            return $connect->insertRowToDB($query);
        }
        
        /**
         * Редактирование данных пользователя
         * @param string $name
         * @param string $password
         */
        public static function edit($id, $name, $password) {
            $db = Db::getConnection();
            
            $sql = "UPDATE user 
                SET name = :name, password = :password 
                WHERE id = :id";
            
            $result = $db->prepare($sql);                                  
            $result->bindParam(':id', $id, PDO::PARAM_INT);       
            $result->bindParam(':name', $name, PDO::PARAM_STR);    
            $result->bindParam(':password', $password, PDO::PARAM_STR); 
            return $result->execute();
        }

        /**
         * Проверяем существует ли пользователь с заданными $email и $password
         * @param string $email
         * @param string $password
         * @return mixed : ingeger user id or false
         */
        public static function checkUserData($email, $password) {
            
            include_once ROOT . '/db/connect.php';
            $connect = new DB;
            $options = [
                'cost' => 12,
                'salt' => 'alexander&ruslan$',
            ];
            $pwd = crypt($password, '$6$rounds=5000$usesomesillystringforsalt$');
            $query = "SELECT * FROM at_adm_users WHERE email_user = '$email' AND pwd_user = '$pwd'";

            $user = $connect->getList($query, 6);
            if ($user) {
                return $user['id_user'];
            }

            return false;
        }

        /**
         * Запоминаем пользователя
         * @param string $email
         * @param string $password
         */
        public static function auth($userId) {
            $_SESSION['user'] = $userId;
        }

        public static function checkLogged() {
            // Если сессия есть, вернем идентификатор пользователя
            if (isset($_SESSION['user'])) {
                return $_SESSION['user'];
            }

            header("Location: /user/login");
        }

        public static function isGuest() {
            if (isset($_SESSION['user'])) {
                return false;
            }
            return true;
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
        
        /**
         * Returns user by id
        * @param integer $id
        */
        public static function getUserById($id) {
            if ($id) {
                $db = Db::getConnection();
                $sql = 'SELECT * FROM user WHERE id = :id';

                $result = $db->prepare($sql);
                $result->bindParam(':id', $id, PDO::PARAM_INT);

                // Указываем, что хотим получить данные в виде массива
                $result->setFetchMode(PDO::FETCH_ASSOC);
                $result->execute();


                return $result->fetch();
            }
        }
    }
?>