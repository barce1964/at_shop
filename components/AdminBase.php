<?php

    /**
     * Абстрактный класс AdminBase содержит общую логику для контроллеров, которые 
     * используются в панели администратора
     */
    abstract class AdminBase {

        /**
         * Метод, который проверяет пользователя на то, является ли он администратором
         * @return boolean
         */
        public static function checkAdmin() {
            // Проверяем авторизирован ли пользователь. Если нет, он будет переадресован
            $userId = User::checkLogged();

            // Получаем информацию о текущем пользователе
            //$roles = User::getUserRoles($userId);

            // Если роль текущего пользователя "admin", пускаем его в админпанель
            if (isset($_SESSION['roles'])) {
                foreach ($_SESSION['roles'] as $role) {
                    if ($role['id_role'] == 1) {
                        return true;
                    }
                }
            }

            // Иначе завершаем работу с сообщением об закрытом доступе
            //die('Access denied');
        }

        public static function getRoles() {
            $userId = User::checkLogged();
            $roles = User::getUserRoles($userId);
            $_SESSION['roles'] = $roles;
        }

    }
?>