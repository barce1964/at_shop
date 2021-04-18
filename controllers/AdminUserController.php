<?php

    /**
     * Контроллер AdminCategoryController
     * Управление категориями товаров в админпанели
     */
    class AdminUserController extends AdminBase {

        /**
         * Action для страницы "Управление пользователями"
         */
        public function actionIndex() {
            // Проверка доступа
            self::checkAdmin();

            // Получаем список пользователей
            $usersList = User::getUsersList();

            // Подключаем вид
            require_once(ROOT . '/views/admin_user/index.php');
            return true;
        }

        /**
         * Action для страницы "Добавить категорию"
         */
        public function actionCreate() {
            // Проверка доступа
            self::checkAdmin();
            
            $roles_html = array();
            $roles = User::getRolesList();
            // Обработка формы
            if (isset($_POST['submit'])) {
                // Если форма отправлена
                // Получаем данные из формы
                //print_r($_POST['roles_html']);
                $name = $_POST['name'];
                $email = $_POST['email'];
                $phone = $_POST['phone'];
                $pwd = $_POST['pwd'];

                // Флаг ошибок в форме
                $errors = false;

                // При необходимости можно валидировать значения нужным образом
                if (!isset($name) || empty($name)) {
                    $errors[] = 'Заполните поля';
                }

                if (!User::checkName($name)) {
                    $errors[] = 'Имя не должно быть короче 2-х символов';
                }
                
                if (!User::checkEmail($email)) {
                    $errors[] = 'Неправильный email';
                }
                
                if (!User::checkPassword($pwd)) {
                    $errors[] = 'Пароль не должен быть короче 8-ми символов';
                }
                
                if (User::checkEmailExists($email)) {
                    $errors[] = 'Такой email уже используется';
                }
                
                if (!User::checkPhone($phone)) {
                    $errors[] = 'Номер телефона должен быть не менее 10 цифр';
                }

                if ($errors == false) {
                    // Если ошибок нет
                    // Добавляем нового пользователя
                    $roles_html = $_POST['roles_html'];

                    User::register($name, $email, $phone, $pwd);
                    User::addRoles($email, $roles_html);

                    // Перенаправляем пользователя на страницу управления пользователями
                    header("Location: /admin/user");
                }
            }

            require_once(ROOT . '/views/admin_user/create.php');
            return true;
        }

        /**
         * Action для страницы "Редактировать пользователя"
         */
        public function actionUpdate($id) {
            // Проверка доступа
            self::checkAdmin();

            $name = '';
            $email = '';
            $phone = '';
            $pwd = '';
            $cif = '';
            $iv = '';
            $key = '';

            // Получаем данные о конкретной категории
            $user = User::getUserById($id);

            $roles_html = array();
            $roles = User::getRolesList();
            $roles_user = User::getUserRoles($id);

            $name = $user['name_user'];
            $email = $user['email_user'];
            $phone = $user['phone_user'];
            $pwd = $user['pwd_user'];
            $cif = $user['user_cif'];
            $iv = $user['user_iv'];
            $key = $user['user_key'];
            $password = openssl_decrypt($pwd, $cif, $key, $options=0, $iv);

            // Обработка формы
            if (isset($_POST['submit'])) {
                // Если форма отправлена   
                // Получаем данные из формы
                // $name = $_POST['name'];
                // $email = $_POST['email'];
                // $phone = $_POST['phone'];
                $pwd = $_POST['pwd'];

                // Флаг ошибок в форме
                $errors = false;

                if (!User::checkPassword($pwd)) {
                    $errors[] = 'Пароль не должен быть короче 8-ми символов';
                }

                if ($errors == false) {
                    // Если ошибок нет
                    // Добавляем нового пользователя
                    $roles_html = $_POST['roles_html'];

                    User::edit($id, $name, $email, $phone, $pwd);
                    User::deleteRoles($id);
                    User::addRoles($email, $roles_html);

                    // Перенаправляем пользователя на страницу управления пользователями
                    header("Location: /admin/user");
                }

            }

            require_once(ROOT . '/views/admin_user/update.php');
            return true;
        }

        /**
         * Action для страницы "Удалить пользователя"
         */
        public function actionDelete($Id) {
            // Проверка доступа
            self::checkAdmin();

            // Обработка формы
            if (isset($_POST['submit'])) {
                // Если форма отправлена
                // Удаляем категорию

                User::deleteUserById($Id);

                    // Перенаправляем пользователя на страницу управлениями товарами
                    header("Location: /admin/user");
                }

            // Подключаем вид
            require_once(ROOT . '/views/admin_user/delete.php');
            return true;
        }

    }

?>
