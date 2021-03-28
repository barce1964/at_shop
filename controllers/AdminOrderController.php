<?php

    /**
     * Контроллер AdminOrderController
     * Управление заказами в админпанели
     */
    class AdminOrderController extends AdminBase {

        /**
         * Action для страницы "Управление заказами"
         */
        public function actionIndex() {
            // Проверка доступа
            //self::checkAdmin();

            // Получаем список заказов
            $ordersList = Order::getOrdersList();
            
            // Подключаем вид
            require_once(ROOT . '/views/admin_order/index.php');
            return true;
        }

        /**
         * Action для страницы "Редактирование заказа"
         */
        public function actionUpdate($id) {
            // Проверка доступа
            //self::checkAdmin();

            // Получаем данные о конкретном заказе
            $order = Order::getOrderById($id);

            // Обработка формы
            if (isset($_POST['submit'])) {
                // Если форма отправлена   
                // Получаем данные из формы
                
                $status = $_POST['status'];

                // Сохраняем изменения
                Order::updateOrderById($id, $status);

                // Перенаправляем пользователя на страницу управлениями заказами
                header("Location: /admin/order/view/$id");
            }

            // Подключаем вид
            require_once(ROOT . '/views/admin_order/update.php');
            return true;
        }

        /**
         * Action для страницы "Просмотр заказа"
         */
        public function actionView($id) {
            // Проверка доступа
            //self::checkAdmin();

            // // Получаем данные о конкретном заказе
            $order = Order::getOrderById($id);

            // Получаем список товаров в заказе
            $products = Order::getOrdDetail($id);

            // Подключаем вид
            require_once(ROOT . '/views/admin_order/view.php');
            return true;
        }

        /**
         * Action для страницы "Удалить заказ"
         */
        public function actionDelete($id) {
            // Проверка доступа
            //self::checkAdmin();

            // Обработка формы
            if (isset($_POST['submit'])) {
                // Если форма отправлена
                // Удаляем заказ
                Order::deleteOrderById($id);

                // Перенаправляем пользователя на страницу управлениями заказами
                header("Location: /admin/order");
            }

            // Подключаем вид
            require_once(ROOT . '/views/admin_order/delete.php');
            return true;
        }

    }
?>