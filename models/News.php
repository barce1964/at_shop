<?php

    class News {

        public static function getNewsItemById($id) {
            include_once ROOT . '/db/connect.php';

            $con = mysqli_connect($host, $user, $pwd, $db) 
                or die("Ошибка " . mysqli_error($con));

            $result = mysqli_query($con, 'select * from at_news
                where id_news = ' . $id);

            return mysqli_fetch_row($result);
            mysqli_close($con);
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
                $newsList[$i]['id_news'] = $row[0];
                $newsList[$i]['title'] = $row[1];
                $newsList[$i]['date'] = $row[2];
                $newsList[$i]['short_content'] = $row[3];
                $i++;
            }
            mysqli_close($con);
            return $newsList;
        }
    }
?>