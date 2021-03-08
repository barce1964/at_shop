<?php
    class Category {
        public static function getCategoriesList() {
            include_once ROOT . '/db/connect.php';

            $connect = new DB;
            $query = 'select id_cat, name_cat from at_shop_cat where status_cat=1 ORDER BY id_cat';

            return $connect->getList($query, 2);
        }
    }
?>