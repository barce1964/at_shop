<?php
    class Category {
        public static function getCategoriesList() {
            include_once ROOT . '/db/connect.php';

            $connect = new DB;
            $query = 'select * from at_shop_cat ORDER BY id_cat';

            return $connect->getList($query, 2);
        }

        /**
         * Удаляет категорию с заданным id
         * @param integer $id
         * @return boolean <p>Результат выполнения метода</p>
         */
        public static function deleteCategoryById($id) {
            // Соединение с БД
            include_once ROOT . '/db/connect.php';
            $db = new Db();

            // Текст запроса к БД
            $sql = "DELETE FROM at_shop_cat WHERE id_cat = $id";

            // Получение и возврат результатов. Используется подготовленный запрос
            return $db->deleteRowFromTable($sql);
        }

        /**
         * Редактирование категории с заданным id
         * @param integer $id <p>id категории</p>
         * @param string $name <p>Название</p>
         * @param integer $sortOrder <p>Порядковый номер</p>
         * @param integer $status <p>Статус <i>(включено "1", выключено "0")</i></p>
         * @return boolean <p>Результат выполнения метода</p>
         */
        public static function updateCategoryById($id, $name, $sortOrder, $status) {
            // Соединение с БД
            include_once ROOT . '/db/connect.php';
            $db = new Db();

            // Текст запроса к БД
            $sql = "UPDATE at_shop_cat
                SET 
                    name_cat = '$name', 
                    sort_order = $sortOrder, 
                    status_cat = $status
                WHERE id_cat = $id";

            // Получение и возврат результатов. Используется подготовленный запрос
            return $db->updateRowInTable($sql);
        }

        /**
         * Возвращает категорию с указанным id
         * @param integer $id <p>id категории</p>
         * @return array <p>Массив с информацией о категории</p>
         */
        public static function getCategoryById($id) {
            // Соединение с БД
            include_once ROOT . '/db/connect.php';
            $db = new Db();

            // Текст запроса к БД
            $sql = "SELECT * FROM at_shop_cat WHERE id_cat = $id";

            // Используется подготовленный запрос
            // $result = $db->prepare($sql);
            // $result->bindParam(':id', $id, PDO::PARAM_INT);

            // Указываем, что хотим получить данные в виде массива
            // $result->setFetchMode(PDO::FETCH_ASSOC);

            // Выполняем запрос
            //$result->execute();

            // Возвращаем данные
            return $db->getList($sql, 2);
        }

        /**
         * Возвращает текстое пояснение статуса для категории :<br/>
         * <i>0 - Скрыта, 1 - Отображается</i>
         * @param integer $status <p>Статус</p>
         * @return string <p>Текстовое пояснение</p>
         */
        public static function getStatusText($status) {
            switch ($status) {
                case '1':
                    return 'Отображается';
                    break;
                case '0':
                    return 'Скрыта';
                    break;
            }
        }

        /**
         * Добавляет новую категорию
         * @param string $name <p>Название</p>
         * @param integer $sortOrder <p>Порядковый номер</p>
         * @param integer $status <p>Статус <i>(включено "1", выключено "0")</i></p>
         * @return boolean <p>Результат добавления записи в таблицу</p>
         */
        public static function createCategory($name, $sortOrder, $status) {
            // Соединение с БД
            include_once ROOT . '/db/connect.php';
            $db = new Db();

            // Текст запроса к БД
            $sql = "INSERT INTO at_shop_cat (name_cat, sort_order, status_cat) "
                    . "VALUES ('$name', $sortOrder, $status)";

            return $db->insertRowToDB($sql);
        }

        public static function getProductCountInCategory($Id) {
            include_once ROOT . '/db/connect.php';
            $db = new Db();

            $sql = "SELECT COUNT(*) FROM at_shop_prod WHERE id_cat = $Id";
            return $db->getList($sql, 13);
        }
    }
?>