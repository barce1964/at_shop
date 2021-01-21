<?php
    class DB {
        public $host = 'localhost';
        public $db = 'at_shop';
        public $user = 'alex';
        public $pwd = 'A20v10T1964';

        public function getSelection($qry) {
            
            $con = mysqli_connect($this->host, $this->user, $this->pwd, $this->db) 
                or die("Ошибка " . mysqli_error($con));
            
                $result = mysqli_query($con, $qry)
                    or die("Ошибка " . mysqli_error($con));
                mysqli_close($con);
                return mysqli_fetch_row($result);
        }

        public function getNewsList($qry) {
            
            $con = mysqli_connect($this->host, $this->user, $this->pwd, $this->db) 
                or die("Ошибка " . mysqli_error($con));
            
            $newsList = array();

            $result = mysqli_query($con, $qry)
                or die("Ошибка " . mysqli_error($con));

            $i = 0;
            while ($row = mysqli_fetch_row($result)) {
                $newsList[$i]['id_news'] = $row[0];
                $newsList[$i]['title'] = $row[1];
                $newsList[$i]['date'] = $row[2];
                $newsList[$i]['author_name'] = $row[3];
                $newsList[$i]['short_content'] = $row[4];
                $i++;
            }
            mysqli_close($con);
            return $newsList;
        }

    }


    
?>