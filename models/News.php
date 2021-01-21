<?php

    class News {

        public static function getNewsItemById($id) {
            include_once ROOT . '/db/connect.php';

            $connect = new DB;
            $query = 'select * from at_news where id_news = ' . $id;
            
            return $connect->getSelection($query);
        }

        public static function getNewsList() {
            include_once ROOT . '/db/connect.php';

            $connect = new DB;
            $query = 'select id_news, title, date, author_name, short_content
                from at_news
                order by date desc
                limit 10';

            return $connect->getNewsList($query);
        }
    }
?>