<?php

    // include_once ROOT . '/models/Category.php';
    // include_once ROOT . '/models/Product.php';

    class SiteController {
        public function actionIndex() {
            $categories = array();
            $categories = Category::getCategoriesList();

            $latestProducts = array();
            $latestProducts = Product::getLatestProducts(6);

            require_once(ROOT . '/views/site/index.php');

            return true;
        }

        public function actionContact() {
            require_once ROOT . '/mailer/PHPMailerAutoload.php';

            if (isset($_SESSION['user'])) {
                $user = User::getUserById($_SESSION['user']);
                $userEmail = $user['email_user'];
                $userName = $user['name_user'];
            } else {
                $userEmail = '';
                $userName = '';
            }
            
            $userSubject = '';
            $userText = '';
            $result = false;
            
            if (isset($_POST['submit'])) {
                
                $userEmail = $_POST['userEmail'];
                $userSubject = $_POST['userSubject'];
                $userText = $_POST['userText'];
      
                $errors = false;
                            
                // Валидация полей
                if (!User::checkEmail($userEmail)) {
                    $errors[] = 'Неправильный email';
                }
                
                if ($errors == false) {

                    $mail = new PHPMailer;
                    $mail->CharSet = 'utf-8';

                    $mail->isSMTP();
                    $mail->Host = 'smtp.gmail.com';
                    $mail->SMTPAuth = true;
                    $mail->Username = 'alexvictar@gmail.com';
                    $mail->Password = 'Ale20X10v19T1964_ex10';
                    $mail->SMTPSecure = 'ssl';
                    $mail->Port = 465;
 
                    if ($userName != '') {
                        $mail->setFrom($userEmail, $userName);
                    } else {
                        $mail->setFrom($userEmail, $userEmail);
                    }
                     
                    $mail->addAddress('alexvictar@mail.ru');

                    $mail->isHTML(true);

                    $mail->Subject = $userSubject;
                    $mail->Body = $userText;

                    if(!$mail->send()) {
                        $result = false;
                    } else {
                        $result = true;
                    }
                    
                }
    
            }

            require_once(ROOT . '/views/site/contact.php');
            
            return true;
        }   
    }

?>