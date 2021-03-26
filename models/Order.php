<?php

    class Order{

        private static function genNumOrd() {
            $i = 1;
            $strg = '';
            while ($i <= 10) {
                $shr_code = mt_rand ( 48, 90);
                if (($shr_code >= 48 && $shr_code <= 57) || ($shr_code >= 65 && $shr_code <= 90)) {
                    $shr = chr($shr_code);
                    $strg = $strg . $shr;
                    $i++;
                }
            }
            return $strg;
        }

        /**
         * Сохранение заказа 
         * @param type $name
         * @param type $email
         * @param type $password
         * @return type
         */
        public static function save($userName, $userPhone, $userId, $products) {
            include_once ROOT . '/db/connect.php';

            $prodKeys = array_keys($products);
            $productList = Product::getProdustsByIds($prodKeys);
            $total = Cart::getTotalPrice($productList);
            $nameOrd = $userId . '-' . $userName . '-' . self::genNumOrd();
            $nameOrd = mb_strtoupper($nameOrd);
            $connect = new DB();

            $sql = "INSERT INTO at_shop_orders (id_user, name_ord, total_ord)
                VALUES ($userId, '$nameOrd', $total)";
            $err1 = $connect->insertRowToDB($sql);
            
            $sql = "SELECT id_ord FROM at_shop_orders WHERE id_user = $userId AND ord_is_detail = 0";
            $ordId = $connect->getList($sql, 5);
            
            $sql = "INSERT INTO at_shop_order_detail (id_ord, id_prod, prod_quantity, prod_sum) VALUES ";
            foreach ($productList as $item) {
                $sql = $sql . "($ordId, " . $item['id_prod'] . ", " . $products[$item['id_prod']] . ", " . $item['price_prod'] * $products[$item['id_prod']] . "), ";
            }
            $sql = trim($sql, ", ");
            $err2 = $connect->insertRowToDB($sql);
            
            $sql = "UPDATE at_shop_orders SET ord_is_detail = 1 WHERE id_ord = $ordId";
            $err3 = $connect->updateRowInTable($sql);
                        
            if ($err1 || $ordId || $err2 || err3) {
                return $ordId;
            } else {
                return false;
            }
        }

        public static function getOrd($idOrd) {
            include_once ROOT . '/db/connect.php';
            $connect = new DB();

            $sql = "SELECT name_ord, date_ord, total_ord, , ord_is_finish FROM at_shop_orders WHERE id_ord = $idOrd";
            return $connect->getList($sql, 9);
        }

        public static function getOrdDetail($idOrd) {
            include_once ROOT . '/db/connect.php';
            $connect = new DB();

            $sql = "SELECT b.code_prod, b.name_prod, b.price_prod, a.prod_quantity, a.prod_sum
                FROM at_shop_order_detail a, at_shop_prod b WHERE a.id_ord = $idOrd AND a.id_prod = b.id_prod";
            return $connect->getList($sql, 10);
        }

        /**
         * Возвращает список заказов
        * @return array <p>Список заказов</p>
        */
        public static function getOrdersList() {
            // Соединение с БД
            include_once ROOT . '/db/connect.php';
            $db = new Db();

            // Получение и возврат результатов
            $sql = "SELECT a.id_ord, a.name_ord, b.name_user, b.phone_user, a.date_ord, a.ord_is_finish
                FROM at_shop_orders a, at_adm_users b
                WHERE a.id_user = b.id_user ORDER BY a.date_ord DESC";
            
            return $db->getList($sql, 14);
        }

        /**
         * Возвращает текстое пояснение статуса для заказа :<br/>
         * <i>1 - Новый заказ, 2 - В обработке, 3 - Доставляется, 4 - Закрыт</i>
         * @param integer $status <p>Статус</p>
         * @return string <p>Текстовое пояснение</p>
         */
        public static function getStatusText($status) {
            switch ($status) {
                case '1':
                    return 'Новый заказ';
                    break;
                case '2':
                    return 'В обработке';
                    break;
                case '3':
                    return 'Доставляется';
                    break;
                case '4':
                    return 'Закрыт';
                    break;
            }
        }

        /**
         * Возвращает заказ с указанным id 
         * @param integer $id <p>id</p>
         * @return array <p>Массив с информацией о заказе</p>
         */
        public static function getOrderById($id) {
            // Соединение с БД
            include_once ROOT . '/db/connect.php';
            $db = new DB();

            // Текст запроса к БД
            $sql = "SELECT a.name_ord, a.date_ord, a.total_ord, a.ord_is_finish, b.name_user, b.phone_user
                FROM at_shop_orders a, at_adm_users b WHERE id_ord = $id AND a.id_user = b.id_user";

            // Возвращаем данные
            return $db->getList($sql, 15);
        }

        /**
         * Удаляет заказ с заданным id
         * @param integer $id <p>id заказа</p>
         * @return boolean <p>Результат выполнения метода</p>
         */
        public static function deleteOrderById($id) {
            // Соединение с БД
            include_once ROOT . '/db/connect.php';
            $db = new Db();

            // Получение и возврат результатов. Используется подготовленный запрос
            $sql = "DELETE FROM at_shop_order_detail WHERE id_ord = $id";
            $result1 = $db->deleteRowFromTable($sql);

            $sql = "DELETE FROM at_shop_orders WHERE id_ord = $id";
            $result2 = $db->deleteRowFromTable($sql);

            if ($result1 || $result2) {
                return true;
            } else {
                return false;
            }
        }

        /**
         * Редактирует заказ с заданным id
         * @param integer $id <p>id товара</p>
         * @param string $userName <p>Имя клиента</p>
         * @param string $userPhone <p>Телефон клиента</p>
         * @param string $userComment <p>Комментарий клиента</p>
         * @param string $date <p>Дата оформления</p>
         * @param integer $status <p>Статус <i>(включено "1", выключено "0")</i></p>
         * @return boolean <p>Результат выполнения метода</p>
         */
        public static function updateOrderById($id, $userName, $userPhone, $userComment, $date, $status) {
            // Соединение с БД
            $db = Db::getConnection();

            // Текст запроса к БД
            $sql = "UPDATE product_order
                SET 
                    user_name = :user_name, 
                    user_phone = :user_phone, 
                    user_comment = :user_comment, 
                    date = :date, 
                    status = :status 
                WHERE id = :id";

            // Получение и возврат результатов. Используется подготовленный запрос
            $result = $db->prepare($sql);
            $result->bindParam(':id', $id, PDO::PARAM_INT);
            $result->bindParam(':user_name', $userName, PDO::PARAM_STR);
            $result->bindParam(':user_phone', $userPhone, PDO::PARAM_STR);
            $result->bindParam(':user_comment', $userComment, PDO::PARAM_STR);
            $result->bindParam(':date', $date, PDO::PARAM_STR);
            $result->bindParam(':status', $status, PDO::PARAM_INT);
            return $result->execute();
        }

    }
?>