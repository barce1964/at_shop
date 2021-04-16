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

                    // Перенаправляем пользователя на страницу управлениями категориями
                    header("Location: /admin/user");
                }
            }

            require_once(ROOT . '/views/admin_user/create.php');
            return true;
        }

        /**
         * Action для страницы "Редактировать категорию"
         */
        public function actionUpdate($id) {
            // Проверка доступа
            self::checkAdmin();

            // Получаем данные о конкретной категории
            $category = Category::getCategoryById($id);

            // Обработка формы
            if (isset($_POST['submit'])) {
                // Если форма отправлена   
                // Получаем данные из формы
                $name = $_POST['name'];
                $sortOrder = $_POST['sort_order'];
                $status = $_POST['status'];

                // Сохраняем изменения
                Category::updateCategoryById($id, $name, $sortOrder, $status);

                // Перенаправляем пользователя на страницу управлениями категориями
                header("Location: /admin/category");
            }

            // Подключаем вид
            require_once(ROOT . '/views/admin_category/update.php');
            return true;
        }

        /**
         * Action для страницы "Удалить категорию"
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
