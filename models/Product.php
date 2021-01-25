<?php

    class Product {

        const SHOW_BY_DEFAULT = 10;

        public static function getLatestProducts($count = self::SHOW_BY_DEFAULT) {
            include_once ROOT . '/db/connect.php';

            $connect = new DB;

            $count = intval($count);
           
            //$productsList = array();

            $query = 'SELECT id_prod, name_prod, price_prod, image_prod, is_new FROM at_shop_prod '
                . 'WHERE status_prod = "1"'
                . 'ORDER BY id_prod '                
                . 'LIMIT ' . $count;

            // $result = $db->query('SELECT id, name, price, image, is_new FROM product '
            //     . 'WHERE status = "1"'
            //     . 'ORDER BY id DESC '                
            //     . 'LIMIT ' . $count);
            
            // $i = 0;
            // while ($row = $result->fetch()) {
            //     $productsList[$i]['id'] = $row['id'];
            //     $productsList[$i]['name'] = $row['name'];
            //     $productsList[$i]['image'] = $row['image'];
            //     $productsList[$i]['price'] = $row['price'];
            //     $productsList[$i]['is_new'] = $row['is_new'];
            //     $i++;
            // }

            return $connect->getList($query, 3);
        }
    
        public static function getProductsListByCategory($categoryId = false) {
            if ($categoryId) {
                $connect = new DB;
                //$db = Db::getConnection(); 
                //$products = array();
                $query="SELECT id_prod, name_prod, price_prod, image_prod, is_new FROM at_shop_prod "
                    . "WHERE status_prod = '1' AND id_cat = '$categoryId' "
                    . "ORDER BY id_prod "                
                    . "LIMIT ". self::SHOW_BY_DEFAULT;

                // $i = 0;
                // while ($row = $result->fetch()) {
                //     $products[$i]['id'] = $row['id'];
                //     $products[$i]['name'] = $row['name'];
                //     $products[$i]['image'] = $row['image'];
                //     $products[$i]['price'] = $row['price'];
                //     $products[$i]['is_new'] = $row['is_new'];
                //     $i++;
                // }

                // return $products;
                return $connect->getList($query, 3);
            }
        }
    
    
        public static function getProductById($id) {
            $id = intval($id);
            
            if ($id) {                        
                // $db = Db::getConnection();
                $connect = new DB;
                $query = 'SELECT * FROM at_shop_prod WHERE id_prod=' . $id;
                //$result->setFetchMode(PDO::FETCH_ASSOC);
            
                return $connect->getList($query, 4);
            }
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

    }

?>