<?php

    class User {
        private static function genStr($step) {
            $i = 1;
            $strg = '';
            while ($i <= $step) {
                $shr_code = mt_rand ( 33, 124);
                if ($shr_code != 34 && $shr_code != 39 && $shr_code != 44 && $shr_code != 46 && $shr_code != 47 && $shr_code != 96) {
                    $shr = chr($shr_code);
                    $strg = $strg . $shr;
                    $i++;
                }
            }
            return $strg;
        }

        public static function register($name, $email, $password) {

            include_once ROOT . '/db/connect.php';
            $connect = new DB();
            $cipher = "aes-256-ofb";
            $iv = User::genStr(16);//openssl_random_pseudo_bytes($ivlen);
            $key = User::genStr(32);
            $pwd = openssl_encrypt($password, $cipher, $key, $options=0, $iv);
            //$pwd = crypt($password, '$6$rounds=5000$usesomesillystringforsalt$');
            
            $query = 'INSERT INTO at_adm_users (name_user, email_user, pwd_user, user_cif, user_iv, user_key) '
                . "VALUES ('$name', '$email', '$pwd', '$cipher', '$iv', '$key')";
            
            return $connect->insertRowToDB($query);
        }
        
        /**
         * Редактирование данных пользователя
         * @param string $name
         * @param string $password
         */
        public static function edit($id, $name, $email, $password) {
            //$db = Db::getConnection();
            $connect = new DB();
            $cipher = "aes-256-ofb";
            $iv = User::genStr(16);//openssl_random_pseudo_bytes($ivlen);
            $key = User::genStr(32);
            $pwd = openssl_encrypt($password, $cipher, $key, $options=0, $iv);
            $sql = "UPDATE at_adm_users SET name_user = '$name', email_user = '$email',
                pwd_user = '$pwd', user_cif = '$cipher', user_iv = '$iv', user_key = '$key'
                WHERE id_user = $id";
        
            return $connect->updateRowInTable($sql);
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
            
            //$pwd = crypt($password, '$6$rounds=5000$usesomesillystringforsalt$');
            
            $query = "SELECT * FROM at_adm_users WHERE email_user = '$email'";

            $user = $connect->getList($query, 6);
            $cipher = $user['user_cif'];
            $iv = $user['user_iv'];//openssl_random_pseudo_bytes($ivlen);
            $key = $user['user_key'];
            $pwd = openssl_encrypt($password, $cipher, $key, $options=0, $iv);
            $query = "SELECT * FROM at_adm_users WHERE email_user = '$email' and pwd_user = '$pwd'";
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
            } else {
                header("Location: /user/login");
            }
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
            include_once ROOT . '/db/connect.php';

            if ($id) {
                $connect = new DB();

                $sql = 'SELECT * FROM at_adm_users WHERE id_user = ' . $id;

                return $connect->getList($sql, 6);
            }
        }
    }
?>