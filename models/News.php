<?php

    class News {

        public static function getNewsItemById($id) {

        }

        public static function getNewsList() {
            include_once ROOT . '/db/connect.php';
            $con = mysqli_connect($host, $user, $pwd, $db) 
                or die("Ошибка " . mysqli_error($con));

            $newsList = array();

            $result = mysqli_query($con, 'select id_news, title, date, short_content
                from at_news
                order by date desc
                limit 10')
                or die("Ошибка " . mysqli_error($con));

            $i = 0;
            while ($row = mysqli_fetch_row($result)) {
                $newsList[$i]['id_news'] = $row['id_news'];
                $newsList[$i]['title'] = $row['title'];
                $newsList[$i]['date'] = $row['date'];
                $newsList[$i]['short_content'] = $row['short_content'];
            }
            mysql_close($con);
            return $newsList;
        }
    }
?>