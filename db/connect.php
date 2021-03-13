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

            $result = mysqli_query($con, $qry)
                or die("Ошибка " . mysqli_error($con));
            
            $i = 0;
            switch ($idx) {
                case 1:
                    $returnList = array();
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
                    $returnList = array();
                    while ($row = mysqli_fetch_row($result)) {
                        $returnList[$i]['id_cat'] = $row[0];
                        $returnList[$i]['name_cat'] = $row[1];
                        $i++;
                    }
                    break;

                case 3:
                    $returnList = array();
                    while ($row = mysqli_fetch_row($result)) {
                        $returnList[$i]['id_prod'] = $row[0];
                        $returnList[$i]['name_prod'] = $row[1];
                        $returnList[$i]['price_prod'] = $row[2];
                        $returnList[$i]['image_prod'] = $row[3];
                        $returnList[$i]['is_new'] = $row[4];
                        $i++;
                    }
                    break;

                    case 4:
                        $returnList = array();
                        while ($row = mysqli_fetch_row($result)) {
                            $returnList[$i]['id_prod'] = $row[0];
                            $returnList[$i]['id_cat'] = $row[1];
                            $returnList[$i]['name_prod'] = $row[2];
                            $returnList[$i]['code_prod'] = $row[3];
                            $returnList[$i]['price_prod'] = $row[4];
                            $returnList[$i]['availability'] = $row[5];
                            $returnList[$i]['brand_prod'] = $row[6];
                            $returnList[$i]['image_prod'] = $row[7];
                            $returnList[$i]['descr_prod'] = $row[8];
                            $returnList[$i]['is_new'] = $row[9];
                            $returnList[$i]['is_rec'] = $row[10];
                            $returnList[$i]['status_prod'] = $row[11];
                            $i++;
                        }
                        break;

                    case 5:
                        $row = mysqli_fetch_row($result);
                        $returnList = $row[0];
                        break;

                    case 6:
                        $returnList = array();
                        while ($row = mysqli_fetch_row($result)) {
                            $returnList['id_user'] = $row[0];
                            $returnList['name_user'] = $row[1];
                            $returnList['email_user'] = $row[2];
                            $returnList['phone_user'] = $row[3];
                            $returnList['pwd_user'] = $row[4];
                            $returnList['user_cif'] = $row[5];
                            $returnList['user_iv'] = $row[6];
                            $returnList['user_key'] = $row[7];
                        }
                        break;

                    case 7:
                        $returnList = array();
                        while ($row = mysqli_fetch_row($result)) {
                            $returnList['id_user'] = $row[0];
                            $returnList['name_user'] = $row[1];
                            $returnList['email_user'] = $row[2];
                            $returnList['pwd_user'] = $row[3];
                        }
                        print_r($returnList);
                        break;

                    case 8:
                        $returnList = array();
                        while ($row = mysqli_fetch_row($result)) {
                            $returnList[$i]['id_prod'] = $row[0];
                            $returnList[$i]['code_prod'] = $row[3];
                            $returnList[$i]['name_prod'] = $row[2];
                            $returnList[$i]['price_prod'] = $row[4];
                            $i++;
                        }
                        break;

                    case 9:
                        $returnList = array();
                        $row = mysqli_fetch_row($result);
                        $returnList['name_ord'] = $row[0];
                        $returnList['date_ord'] = $row[1];
                        $returnList['total_ord'] = $row[2];
                        break;
        
                    case 10:
                        $returnList = array();
                        while ($row = mysqli_fetch_row($result)) {
                            $returnList[$i]['prod_name'] = $row[0];
                            $returnList[$i]['prod_price'] = $row[1];
                            $returnList[$i]['prod_quantity'] = $row[2];
                            $returnList[$i]['prod_sum'] = $row[3];
                            $i++;
                        }
                        break;

                    case 11:
                        $returnList = array();
                        while ($row = mysqli_fetch_row($result)) {
                            $returnList[$i]['id_prod'] = $row[0];
                            $returnList[$i]['name_prod'] = $row[1];
                            $returnList[$i]['price_prod'] = $row[2];
                            $returnList[$i]['image_prod'] = $row[3];
                            $returnList[$i]['is_new'] = $row[4];
                            $i++;
                        }
                        break;

                    case 12:
                        $returnList = array();
                        while ($row = mysqli_fetch_row($result)) {
                            $returnList[$i]['id_user'] = $row[0];
                            $returnList[$i]['id_role'] = $row[1];
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

        public function insertRowToDB($qry) {
            $con = mysqli_connect($this->host, $this->user, $this->pwd, $this->db) 
                or die("Ошибка " . mysqli_error($con));

            return mysqli_query($con, $qry)
                or die("Ошибка " . mysqli_error($con));
            
        }

        public function updateRowInTable($qry) {
            $con = mysqli_connect($this->host, $this->user, $this->pwd, $this->db) 
                or die("Ошибка " . mysqli_error($con));

            return mysqli_query($con, $qry)
                or die("Ошибка " . mysqli_error($con));
        }

        public function deleteRowFromTable($qry) {
            $con = mysqli_connect($this->host, $this->user, $this->pwd, $this->db) 
                or die("Ошибка " . mysqli_error($con));

            return mysqli_query($con, $qry)
                or die("Ошибка " . mysqli_error($con));
        }

        public function lastInsertIdProd() {
            $con = mysqli_connect($this->host, $this->user, $this->pwd, $this->db) 
                or die("Ошибка " . mysqli_error($con));

            $qry = 'SELECT MAX(id_prod) FROM at_shop_prod';
            
            $result = mysqli_query($con, $qry)
                or die("Ошибка " . mysqli_error($con));

            $row = mysqli_fetch_row($result);
            return $row[0];
        }
    }


    
?>