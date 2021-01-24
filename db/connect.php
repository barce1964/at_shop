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

        public function getList($qry, $idx) {
            
            $con = mysqli_connect($this->host, $this->user, $this->pwd, $this->db) 
                or die("Ошибка " . mysqli_error($con));
            
            $returnList = array();

            $result = mysqli_query($con, $qry)
                or die("Ошибка " . mysqli_error($con));

            $i = 0;
            switch ($idx) {
                case 1:
                    while ($row = mysqli_fetch_row($result)) {
                        $returnList[$i]['id_news'] = $row[0];
                        $returnList[$i]['title'] = $row[1];
                        $returnList[$i]['date'] = $row[2];
                        $returnList[$i]['author_name'] = $row[3];
                        $returnList[$i]['short_content'] = $row[4];
                        $i++;
                    }
                    break;

                case 2:
                    while ($row = mysqli_fetch_row($result)) {
                        $returnList[$i]['id_cat'] = $row[0];
                        $returnList[$i]['name_cat'] = $row[1];
                        $i++;
                    }
                    break;

                case 3:
                    while ($row = mysqli_fetch_row($result)) {
                        $returnList[$i]['id_prod'] = $row[0];
                        $returnList[$i]['name_prod'] = $row[1];
                        $returnList[$i]['price_prod'] = $row[2];
                        $returnList[$i]['image_prod'] = $row[3];
                        $returnList[$i]['is_new'] = $row[4];
                        $i++;
                    }
                    break;


                default:
                    # code...
                    break;
            }
            
            mysqli_close($con);
            return $returnList;
        }

    }


    
?>