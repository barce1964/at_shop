<?php

    class Product {

        const SHOW_BY_DEFAULT = 6;

        public static function getLatestProducts($count = self::SHOW_BY_DEFAULT) {
            include_once ROOT . '/db/connect.php';

            $connect = new DB;

            $count = intval($count);
           
            $query = 'SELECT id_prod, name_prod, price_prod, image_prod, is_new FROM at_shop_prod '
                . 'WHERE status_prod = "1"'
                . 'ORDER BY id_prod '                
                . 'LIMIT ' . $count;

            return $connect->getList($query, 3);
        }
    
        public static function getProductsListByCategory($categoryId = false, $page=1) {
            include_once ROOT . '/db/connect.php';
            if ($categoryId) {
                $connect = new DB;
                
                $page = intval($page);
                $offset = ($page - 1) * self::SHOW_BY_DEFAULT;

                $query="SELECT id_prod, name_prod, price_prod, image_prod, is_new FROM at_shop_prod "
                    . "WHERE status_prod = '1' AND id_cat = '$categoryId' "
                    . "ORDER BY id_prod "                
                    . "LIMIT ". self::SHOW_BY_DEFAULT
                    . " OFFSET " . $offset;

                return $connect->getList($query, 3);
            }
        }
    
    
        public static function getProductById($id) {
            include_once ROOT . '/db/connect.php';
            $id = intval($id);
            
            if ($id) {                        
               
                $connect = new DB;
                $query = 'SELECT * FROM at_shop_prod WHERE id_prod=' . $id;
                            
                return $connect->getList($query, 4);
            }
        }
    
        public static function getTotalProductsInCategory($categoryId) {
            include_once ROOT . '/db/connect.php';
            $connect = new DB;

            $query = 'SELECT count(id_prod) AS count FROM at_shop_prod '
                . 'WHERE status_prod="1" AND id_cat ="'.$categoryId.'"';

            return $connect->getList($query, 5);
        }

        // public static function getRecommendedProducts() {
        //     $db = Db::getConnection();

        //     $productsList = array();

        //     $result = $db->query('SELECT id, name, price, image, is_new FROM product '
        //         . 'WHERE status = "1" AND is_recommended = "1"'
        //         . 'ORDER BY id DESC ');

        //     $i = 0;
        //     while ($row = $result->fetch()) {
        //         $productsList[$i]['id'] = $row['id'];
        //         $productsList[$i]['name'] = $row['name'];
        //         $productsList[$i]['image'] = $row['image'];
        //         $productsList[$i]['price'] = $row['price'];
        //         $productsList[$i]['is_new'] = $row['is_new'];
        //         $i++;
        //     }

        //     return $productsList;
        // }

        public static function getProdustsByIds($idsArray) {
            include_once ROOT . '/db/connect.php';
            $connect = new DB;
            
            $products = array();
            
            $idsString = implode(',', $idsArray);
            
            $sql = "SELECT * FROM at_shop_prod WHERE status_prod='1' AND id_prod IN ($idsString)";
    
            return $connect->getList($sql, 8);
        }
    }

?>