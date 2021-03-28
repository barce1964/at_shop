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

            // Обработка формы
            if (isset($_POST['submit'])) {
                // Если форма отправлена
                // Получаем данные из формы
                $name = $_POST['name'];
                $sortOrder = $_POST['sort_order'];
                $status = $_POST['status'];

                // Флаг ошибок в форме
                $errors = false;

                // При необходимости можно валидировать значения нужным образом
                if (!isset($name) || empty($name)) {
                    $errors[] = 'Заполните поля';
                }


                if ($errors == false) {
                    // Если ошибок нет
                    // Добавляем новую категорию
                    Category::createCategory($name, $sortOrder, $status);

                    // Перенаправляем пользователя на страницу управлениями категориями
                    header("Location: /admin/category");
                }
            }

            require_once(ROOT . '/views/admin_category/create.php');
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
