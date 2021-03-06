<?php

    /**
     * Контроллер AdminProductController
     * Управление товарами в админпанели
     */
    class AdminProductController extends AdminBase {

        /**
         * Action для страницы "Управление товарами"
         */
        public function actionIndex() {
            $idCat = 1;
            // Получаем список категорий товаров
            $categories = Category::getCategoriesList();

            // Получаем список товаров
            $productsList = Product::getProductsList($idCat);
            $iCount = 0;
            
            // Подключаем вид
            require_once(ROOT . '/views/admin_product/index.php');
            return true;
        }

        /**
         * Action для страницы "Управление товарами"
         */
        public function actionFilt($idCat) {
          
            // Получаем список категорий товаров
            $categories = Category::getCategoriesList();

            // Получаем список товаров
            $productsList = Product::getProductsList($idCat);
            $iCount = 0;

            foreach($categories as $cat) {
                if ($cat['id_cat'] != $idCat) {
                    $iCount++;
                } else {
                    break;
                }
            }

            // Подключаем вид
            require_once(ROOT . '/views/admin_product/index.php');
            return true;
        }

        /**
         * Action для страницы "Добавить товар"
         */
        public function actionCreate() {
            // Проверка доступа
            self::checkAdmin();

            // Получаем список категорий для выпадающего списка
            $categoriesList = Category::getCategoriesList();

            // Обработка формы
            if (isset($_POST['submit'])) {
                // Если форма отправлена
                // Получаем данные из формы
                $options['name'] = $_POST['name'];
                $options['code'] = $_POST['code'];
                $options['price'] = $_POST['price'];
                $options['category_id'] = $_POST['category_id'];
                $options['brand'] = $_POST['brand'];
                $options['availability'] = $_POST['availability'];
                $options['description'] = $_POST['description'];
                $options['is_new'] = $_POST['is_new'];
                $options['is_recommended'] = $_POST['is_recommended'];
                $options['status'] = $_POST['status'];
                $catId = $options['category_id'];
                // Флаг ошибок в форме
                $errors = false;

                // При необходимости можно валидировать значения нужным образом
                if (!isset($options['name']) || empty($options['name'])) {
                    $errors[] = 'Заполните поля';
                }

                if ($errors == false) {
                    // Если ошибок нет
                    // Добавляем новый товар
                    $id = Product::createProduct($options);

                    // Если запись добавлена
                    if ($id) {
                        // Проверим, загружалось ли через форму изображение
                        if (is_uploaded_file($_FILES["image"]["tmp_name"])) {
                            // Если загружалось, переместим его в нужную папке, дадим новое имя
                            move_uploaded_file($_FILES["image"]["tmp_name"], $_SERVER['DOCUMENT_ROOT'] . "/images/shop/{$id}.jpg");
                            include_once ROOT . '/db/connect.php';
                            $db = new DB();
                            $imagePath = "/images/shop/{$id}.jpg";
                            $sql = "UPDATE at_shop_prod SET image_prod = '$imagePath' WHERE id_prod = $id";
                            $db->updateRowInTable($sql);
                        }
                    };

                    // Перенаправляем пользователя на страницу управлениями товарами
                    header("Location: /admin/product/idx$catId");
                }
            }

            // Подключаем вид
            require_once(ROOT . '/views/admin_product/create.php');
            return true;
        }

        /**
         * Action для страницы "Редактировать товар"
         */
        public function actionUpdate($id) {
            // Проверка доступа
            self::checkAdmin();

            // Получаем список категорий для выпадающего списка
            $categoriesList = Category::getCategoriesList();

            // Получаем данные о конкретном товаре
            $product = Product::getProductById($id);

            // Обработка формы
            if (isset($_POST['submit'])) {
                // Если форма отправлена
                // Получаем данные из формы редактирования. При необходимости можно валидировать значения
                $options['name'] = $_POST['name'];
                $options['code'] = $_POST['code'];
                $options['price'] = $_POST['price'];
                $options['category_id'] = $_POST['category_id'];
                $options['brand'] = $_POST['brand'];
                $options['availability'] = $_POST['availability'];
                $options['description'] = $_POST['description'];
                $options['is_new'] = $_POST['is_new'];
                $options['is_recommended'] = $_POST['is_recommended'];
                $options['status'] = $_POST['status'];

                $catId = $options['category_id'];
                // Сохраняем изменения
                if (Product::updateProductById($id, $options)) {


                    // Если запись сохранена
                    // Проверим, загружалось ли через форму изображение
                    if (is_uploaded_file($_FILES["image"]["tmp_name"])) {

                        // Если загружалось, переместим его в нужную папке, дадим новое имя
                        move_uploaded_file($_FILES["image"]["tmp_name"], $_SERVER['DOCUMENT_ROOT'] . "/images/shop/{$id}.jpg");
                    }
                }

                // Перенаправляем пользователя на страницу управлениями товарами
                header("Location: /admin/product/idx$catId");
            }

            // Подключаем вид
            require_once(ROOT . '/views/admin_product/update.php');
            return true;
        }

        /**
         * Action для страницы "Удалить товар"
         */
        public function actionDelete($id, $catId) {
            // Проверка доступа
            self::checkAdmin();

            // Обработка формы
            if (isset($_POST['submit'])) {
                // Если форма отправлена
                // Удаляем товар
                Product::deleteProductById($id);

                // Перенаправляем пользователя на страницу управлениями товарами
                header("Location: /admin/product/idx$catId");
            }

            // Подключаем вид
            require_once(ROOT . '/views/admin_product/delete.php');
            return true;
        }

    }
?>