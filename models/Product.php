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

        public static function getRecommendedProducts() {
            include_once ROOT . '/db/connect.php';
            $connect = new DB;

           $sql = 'SELECT id_prod, name_prod, price_prod, image_prod, is_new FROM at_shop_prod
            WHERE status_prod = "1" AND is_rec = "1"';

            return $connect->getList($sql, 11);
        }

        public static function getProdustsByIds($idsArray) {
            include_once ROOT . '/db/connect.php';
            $connect = new DB;
            
            $products = array();
            
            $idsString = implode(',', $idsArray);
            
            $sql = "SELECT * FROM at_shop_prod WHERE status_prod='1' AND id_prod IN ($idsString)";
    
            return $connect->getList($sql, 8);
        }

        /**
        * Возвращает список товаров
        * @return array <p>Массив с товарами</p>
        */
        public static function getProductsList($idCat = false) {
            
            include_once ROOT . '/db/connect.php';
            $connect = new DB();
            if ($idCat) {
                $sql = "SELECT * FROM at_shop_prod WHERE id_cat = $idCat ORDER BY id_prod ASC";
            } else {
                $sql = 'SELECT * FROM at_shop_prod ORDER BY id_prod ASC';
            }
            
            return $connect->getList($sql, 4);
        }

        /**
        * Удаляет товар с указанным id
        * @param integer $id <p>id товара</p>
        * @return boolean <p>Результат выполнения метода</p>
        */
        public static function deleteProductById($id) {
            // Соединение с БД
            include_once ROOT . '/db/connect.php';
            $db = new Db();
            // Удаление файла изображения
            $sql = "SELECT image_prod FROM at_shop_prod WHERE id_prod = $id";
            $imagePath = $db->getList($sql, 13);
            $imagePath = $_SERVER['DOCUMENT_ROOT'] . $imagePath;
            unlink($imagePath);
            // Текст запроса к БД
            $sql = "DELETE FROM at_shop_prod WHERE id_prod = $id";

            // Получение и возврат результатов. Используется подготовленный запрос
            // $result = $db->prepare($sql);
            // $result->bindParam(':id', $id, PDO::PARAM_INT);
            return $db->deleteRowFromTable($sql);
        }

        /**
        * Редактирует товар с заданным id
        * @param integer $id <p>id товара</p>
        * @param array $options <p>Массив с информацей о товаре</p>
        * @return boolean <p>Результат выполнения метода</p>
        */
        public static function updateProductById($id, $options) {
            // Соединение с БД
            include_once ROOT . '/db/connect.php';
            $db = new Db();

            // Текст запроса к БД
            $sql = "UPDATE at_shop_prod SET name_prod = '$options[name]',
                    code_prod = $options[code], price_prod = $options[price],
                    id_cat =  $options[category_id], brand_prod = '$options[brand]',
                    availability = $options[availability], descr_prod = '$options[description]',
                    is_new = $options[is_new], is_rec = $options[is_recommended],
                    status_prod = $options[status] WHERE id_prod = $id";

            return $db->updateRowInTable($sql);
        }

        /**
        * Добавляет новый товар
        * @param array $options <p>Массив с информацией о товаре</p>
        * @return integer <p>id добавленной в таблицу записи</p>
        */
        public static function createProduct($options) {
            // Соединение с БД
            include_once ROOT . '/db/connect.php';
            $db = new Db();

            // Текст запроса к БД
            $sql = 'INSERT INTO at_shop_prod '
                . '(id_cat, name_prod, code_prod, price_prod, brand_prod, availability,'
                . 'descr_prod, is_new, is_rec, status_prod)'
                . 'VALUES '
                . "($options[category_id],'$options[name]', $options[code], $options[price],"
                . "'$options[brand]', $options[availability], '$options[description]',"
                . "$options[is_new], $options[is_recommended], $options[status])";

            if ($db->insertRowToDB($sql)) {
                // Если запрос выполенен успешно, возвращаем id добавленной записи
                return $db->lastInsertIdProd();
            }
            // Иначе возвращаем 0
            return 0;
        }

        /**
        * Возвращает текстое пояснение наличия товара:<br/>
        * <i>0 - Под заказ, 1 - В наличии</i>
        * @param integer $availability <p>Статус</p>
        * @return string <p>Текстовое пояснение</p>
        */
        public static function getAvailabilityText($availability) {
            switch ($availability) {
                case '1':
                    return 'В наличии';
                    break;
                case '0':
                    return 'Под заказ';
                    break;
            }
        }

        /**
        * Возвращает путь к изображению
        * @param integer $id
        * @return string <p>Путь к изображению</p>
        */
        public static function getImage($id) {
            // Название изображения-пустышки
            $noImage = 'no-image.jpg';

            // Путь к папке с товарами
            $path = '/images/shop/';

            // Путь к изображению товара
            $pathToProductImage = $path . $id . '.jpg';

            if (file_exists($_SERVER['DOCUMENT_ROOT'].$pathToProductImage)) {
                // Если изображение для товара существует
                // Возвращаем путь изображения товара
                return $pathToProductImage;
            }

            // Возвращаем путь изображения-пустышки
            return $path . $noImage;
        }

    }

?>