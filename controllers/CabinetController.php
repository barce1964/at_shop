<?php

    class CabinetController {

        public function actionIndex() {
            // Получаем идентификатор пользователя из сессии
            $userId = User::checkLogged();
            
            // Получаем информацию о пользователе из БД
            $user = array();
            $user = User::getUserById($userId);
            
            require_once(ROOT . '/views/cabinet/index.php');

            return true;
        }  
        
        public function actionEdit() {
            // Получаем идентификатор пользователя из сессии
            $userId = User::checkLogged();
            
            // Получаем информацию о пользователе из БД
            $user = User::getUserById($userId);
            
            $name = $user['name_user'];
            $email = $user['email_user'];
            $pwd = $user['pwd_user'];
            $cif = $user['user_cif'];
            $iv = $user['user_iv'];
            $key = $user['user_key'];
            $password = openssl_decrypt($pwd, $cif, $key, $options=0, $iv);
                    
            $result = false;     

            if (isset($_POST['submit'])) {
                $name = $_POST['name'];
                $email = $_POST['email'];
                $password = $_POST['password'];
                                
                $errors = false;
               
                if (!User::checkName($name)) {
                    $errors[] = 'Имя не должно быть короче 2-х символов';
                }
                
                if (!User::checkEmail($email)) {
                    $errors[] = 'Неправильный email';
                }
                
                if ($password != '') {
                    if (!User::checkPassword($password)) {
                        $errors[] = 'Пароль не должен быть короче 8-ти символов';
                    }
                }
                
                if ($errors == false) {
                    $result = User::edit($userId, $name, $email, $password);
                }

            }

            require_once(ROOT . '/views/cabinet/edit.php');

            return true;
        }

    }

?>