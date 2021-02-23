<?php

    class Order{

        /**
         * Сохранение заказа 
         * @param type $name
         * @param type $email
         * @param type $password
         * @return type
         */
        public static function save($userName, $userPhone, $userId, $products) {
            include_once ROOT . '/db/connect.php';

            //$products = json_encode($products);
            $prodKeys = array_keys($products);
            $productList = Product::getProdustsByIds($prodKeys);
            $total = Cart::getTotalPrice($productList);
            //print_r($products);
            //echo date("d-m-y H:i:s");
            //echo strftime("%d %m %Y %X");
            $connect = new DB();

            $sql = "INSERT INTO at_shop_orders (id_user, name_ord, date_ord, total_ord, ord_is_finish)
                VALUES ($userId, '$userName', '" . date("Y-m-d H:i:s") . "', $total, 1)";
            //$err1 = $connect->insertRowToDB($sql);
            $err1 = true;
            $sql = "SELECT id_ord FROM at_shop_orders WHERE id_user = $userId AND ord_is_detail = 0";
            //$ordId = $connect->getList($sql, 5);
            $ordId = 9;
            $sql = "INSERT INTO at_shop_order_detail (id_ord, prod_name, prod_price, prod_quantity, prod_sum) VALUES ";
            foreach ($productList as $item) {
                $sql = $sql . "($ordId, '" . $item['name_prod'] . "', " . $item['price_prod'] . ", " . $products[$item['id_prod']] . ", " . $item['price_prod'] * $products[$item['id_prod']] . "), ";
            }
            $sql = trim($sql, ", ");
            //echo $sql;
            //$err2 = $connect->insertRowToDB($sql);
            $err2 = true;
            $sql = "UPDATE at_shop_orders SET ord_is_detail = 1 WHERE id_ord = $ordId";
            //$err3 = $connect->updateRowInTable($sql);
            $err3 = true;
            //$db = Db::getConnection();

            // $sql = 'INSERT INTO product_order (user_name, user_phone, user_comment, user_id, products) '
            //         . 'VALUES (:user_name, :user_phone, :user_comment, :user_id, :products)';

            // $result = $db->prepare($sql);
            // $result->bindParam(':user_name', $userName, PDO::PARAM_STR);
            // $result->bindParam(':user_phone', $userPhone, PDO::PARAM_STR);
            // $result->bindParam(':user_comment', $userComment, PDO::PARAM_STR);
            // $result->bindParam(':user_id', $userId, PDO::PARAM_STR);
            // $result->bindParam(':products', $products, PDO::PARAM_STR);

            if ($err1 || $ordId || $err2 || err3) {
                return $ordId;
            } else {
                return false;
            }
        }

        public static function getOrd($idOrd) {
            include_once ROOT . '/db/connect.php';
            $connect = new DB();

            $sql = "SELECT name_ord, date_ord, total_ord FROM at_shop_orders WHERE id_ord = $idOrd";
            return $connect->getList($sql, 9);
        }

        public static function getOrdDetail($idOrd) {
            include_once ROOT . '/db/connect.php';
            $connect = new DB();

            $sql = "SELECT prod_name, prod_price, prod_quantity, prod_sum FROM at_shop_order_detail WHERE id_ord = $idOrd";
            return $connect->getList($sql, 10);
        }

    }
?>