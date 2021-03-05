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
        public static function getProductsList() {
            // Соединение с БД
            //$db = Db::getConnection();
            include_once ROOT . '/db/connect.php';
            $connect = new DB();

            $sql = 'SELECT * FROM at_shop_prod ORDER BY id_prod ASC';
            // Получение и возврат результатов
            // $result = $db->query('SELECT id, name, price, code FROM product ORDER BY id ASC');
            // $productsList = array();
            // $i = 0;
            // while ($row = $result->fetch()) {
            //     $productsList[$i]['id'] = $row['id'];
            //     $productsList[$i]['name'] = $row['name'];
            //     $productsList[$i]['code'] = $row['code'];
            //     $productsList[$i]['price'] = $row['price'];
            //     $i++;
            // }
            return $connect->getList($sql, 4);
        }

        /**
        * Удаляет товар с указанным id
        * @param integer $id <p>id товара</p>
        * @return boolean <p>Результат выполнения метода</p>
        */
        public static function deleteProductById($id) {
            // Соединение с БД
            $db = Db::getConnection();

            // Текст запроса к БД
            $sql = 'DELETE FROM product WHERE id = :id';

            // Получение и возврат результатов. Используется подготовленный запрос
            $result = $db->prepare($sql);
            $result->bindParam(':id', $id, PDO::PARAM_INT);
            return $result->execute();
        }

        /**
        * Редактирует товар с заданным id
        * @param integer $id <p>id товара</p>
        * @param array $options <p>Массив с информацей о товаре</p>
        * @return boolean <p>Результат выполнения метода</p>
        */
        public static function updateProductById($id, $options) {
            // Соединение с БД
            $db = Db::getConnection();

            // Текст запроса к БД
            $sql = "UPDATE product
                SET 
                    name = :name, 
                    code = :code, 
                    price = :price, 
                    category_id = :category_id, 
                    brand = :brand, 
                    availability = :availability, 
                    description = :description, 
                    is_new = :is_new, 
                    is_recommended = :is_recommended, 
                    status = :status
                    WHERE id = :id";

            // Получение и возврат результатов. Используется подготовленный запрос
            $result = $db->prepare($sql);
            $result->bindParam(':id', $id, PDO::PARAM_INT);
            $result->bindParam(':name', $options['name'], PDO::PARAM_STR);
            $result->bindParam(':code', $options['code'], PDO::PARAM_STR);
            $result->bindParam(':price', $options['price'], PDO::PARAM_STR);
            $result->bindParam(':category_id', $options['category_id'], PDO::PARAM_INT);
            $result->bindParam(':brand', $options['brand'], PDO::PARAM_STR);
            $result->bindParam(':availability', $options['availability'], PDO::PARAM_INT);
            $result->bindParam(':description', $options['description'], PDO::PARAM_STR);
            $result->bindParam(':is_new', $options['is_new'], PDO::PARAM_INT);
            $result->bindParam(':is_recommended', $options['is_recommended'], PDO::PARAM_INT);
            $result->bindParam(':status', $options['status'], PDO::PARAM_INT);
            return $result->execute();
        }

        /**
        * Добавляет новый товар
        * @param array $options <p>Массив с информацией о товаре</p>
        * @return integer <p>id добавленной в таблицу записи</p>
        */
        public static function createProduct($options) {
            // Соединение с БД
            $db = Db::getConnection();

            // Текст запроса к БД
            $sql = 'INSERT INTO product '
                . '(name, code, price, category_id, brand, availability,'
                . 'description, is_new, is_recommended, status)'
                . 'VALUES '
                . '(:name, :code, :price, :category_id, :brand, :availability,'
                . ':description, :is_new, :is_recommended, :status)';

            // Получение и возврат результатов. Используется подготовленный запрос
            $result = $db->prepare($sql);
            $result->bindParam(':name', $options['name'], PDO::PARAM_STR);
            $result->bindParam(':code', $options['code'], PDO::PARAM_STR);
            $result->bindParam(':price', $options['price'], PDO::PARAM_STR);
            $result->bindParam(':category_id', $options['category_id'], PDO::PARAM_INT);
            $result->bindParam(':brand', $options['brand'], PDO::PARAM_STR);
            $result->bindParam(':availability', $options['availability'], PDO::PARAM_INT);
            $result->bindParam(':description', $options['description'], PDO::PARAM_STR);
            $result->bindParam(':is_new', $options['is_new'], PDO::PARAM_INT);
            $result->bindParam(':is_recommended', $options['is_recommended'], PDO::PARAM_INT);
            $result->bindParam(':status', $options['status'], PDO::PARAM_INT);
            if ($result->execute()) {
                // Если запрос выполенен успешно, возвращаем id добавленной записи
                return $db->lastInsertId();
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
            $path = '/upload/images/products/';

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