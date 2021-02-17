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
            $mail = new PHPMailer;
            $mail->CharSet = 'utf-8';
                
            $userEmail = '';
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
                    $adminEmail = 'alexvictar@mail.ru';
                    $message = "Текст: {$userText}. От {$userEmail}";
                    $subject = $userSubject;    
                    // $result = mail($adminEmail, $subject, $message);
                    // $result = true;
                }
    
            }
            
            require_once(ROOT . '/views/site/contact.php');
            
            return true;
        }   
    }

?>