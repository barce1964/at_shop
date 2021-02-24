<?php

    class CartController {

        public function actionAdd($id) {
            // Добавляем товар в корзину
            Cart::addProduct($id);

            // Возвращаем пользователя на страницу
            $referrer = $_SERVER['HTTP_REFERER'];
            header("Location: $referrer");
        }

        public function actionAddAjax($id) {
            // Добавляем товар в корзину
            echo Cart::addProduct($id);
            return true;
        }

        public function actionDelete($id) {
            // Удалить товар из корзины
            Cart::deleteProduct($id);
            // Возвращаем пользователя на страницу
            header("Location: /cart/");
        }

        public function actionIndex() {
            $categories = array();
            $categories = Category::getCategoriesList();

            $productsInCart = false;

            // Получим данные из корзины
            $productsInCart = Cart::getProducts();

            if ($productsInCart) {
                // Получаем полную информацию о товарах для списка
                $productsIds = array_keys($productsInCart);
                $products = Product::getProdustsByIds($productsIds);
                
                // Получаем общую стоимость товаров
                $totalPrice = Cart::getTotalPrice($products);
            }

            require_once(ROOT . '/views/cart/index.php');

            return true;
        }

        private static function getHTML($ord, $ordDetail) {
            $result = "";
            foreach ($ordDetail as $product) {
                $result = $result . "<tr>";
                $result = $result . "<td>" . $product['prod_name'] . "</td>";
                $result = $result . "<td align='right'>" . $product['prod_price'] . "</td>";
                $result = $result . "<td align='right'>" . $product['prod_quantity'] . "</td>";
                $result = $result . "<td align='right'>" . $product['prod_sum'] . "</td></tr>";
            }
            $result = $result . "<tr><td colspan='3'>Общая стоимость:</td><td align='right'>" . $ord['total_ord'] . ", тг</td></tr>";
            return $result;
        }

        public function actionCheckout() {

            // Список категорий для левого меню
            $categories = array();
            $categories = Category::getCategoriesList();


            // Статус успешного оформления заказа
            $result = false;


            // Форма отправлена?
            if (isset($_POST['submit'])) {
                // Форма отправлена? - Да
                // Считываем данные формы
                $userName = $_POST['userName'];
                $userPhone = $_POST['userPhone'];
                //$userComment = $_POST['userComment'];

                // Валидация полей
                $errors = false;
                if (!User::checkName($userName))
                    $errors[] = 'Неправильное имя';
                if (!User::checkPhone($userPhone))
                    $errors[] = 'Неправильный телефон';

                // Форма заполнена корректно?
                if ($errors == false) {
                    // Форма заполнена корректно? - Да
                    // Сохраняем заказ в базе данных
                    // Собираем информацию о заказе
                    $productsInCart = Cart::getProducts();
                    if (User::isGuest()) {
                        $userId = false;
                    } else {
                        $userId = User::checkLogged();
                    }

                    // Сохраняем заказ в БД
                    $result = Order::save($userName, $userPhone, $userId, $productsInCart);

                    if ($result) {
                        require_once ROOT . '/mailer/PHPMailerAutoload.php';
                        //echo "test";
                        $user = User::getUserById($_SESSION['user']);
                        $userEmail = $user['email_user'];
                        $userName = $user['name_user'];
                        $userPhone = $user['phone_user'];
                        $ord = Order::getOrd($result);
                        $ordDetail = Order::getOrdDetail($result);

                        // print_r($ord);
                        // echo "<br>";
                        // print_r($ordDetail);

                        $userText = "<!DOCTYPE html>
                            <html>
                                <head>
                                    <meta charset='utf-8'>
                                    <style type='text/css'>
                                        h4 {
                                            padding-top: 0px;
                                            padding-bottom: 0px;
                                            font-size: 20px; 
                                            font-family: Verdana, Arial, Helvetica, sans-serif; 
                                            color: #AA4433;
                                        }
                                    </style>
                                </head>
                                <body>
                                    <h4>Имя:      $userName</h4>
                                    <h4>Email:    $userEmail</h4>
                                    <H4>Телефон:  $userPhone</H4>
                                    <br><br>
                                    <table>
                                        <tr>
                                            <th>Название</th>
                                            <th>Стомость, тг</th>
                                            <th>Количество, шт</th>
                                            <th>Сумма, тг</th>
                                        </tr>" . self::getHTML($ord, $ordDetail) .
                                    "</table>
                                </body>
                            </html>";

                        $mail = new PHPMailer;
                        $mail->CharSet = 'utf-8';

                        $mail->isSMTP();
                        $mail->Host = 'smtp.gmail.com';
                        $mail->SMTPAuth = true;
                        $mail->Username = 'alexvictar@gmail.com';
                        $mail->Password = 'Ale20X10v19T1964_ex10';
                        $mail->SMTPSecure = 'ssl';
                        $mail->Port = 465;

                        $mail->setFrom($userEmail, $userName);

                        $mail->addAddress('alexvictar@mail.ru');

                        $mail->isHTML(true);
    
                        $mail->Subject = "Новый заказ";
                        $mail->Body = $userText;

                        if(!$mail->send()) {
                            $result = false;
                        } else {
                            $result = true;
                        }
                        
                        // Очищаем корзину
                        Cart::clear();
                    }
                } else {
                    // Форма заполнена корректно? - Нет
                    // Итоги: общая стоимость, количество товаров
                    $productsInCart = Cart::getProducts();
                    $productsIds = array_keys($productsInCart);
                    $products = Product::getProdustsByIds($productsIds);
                    $totalPrice = Cart::getTotalPrice($products);
                    $totalQuantity = Cart::countItems();
                }
            } else {
                // Форма отправлена? - Нет
                // Получием данные из корзины      
                $productsInCart = Cart::getProducts();

                // В корзине есть товары?
                if ($productsInCart == false) {
                    // В корзине есть товары? - Нет
                    // Отправляем пользователя на главную искать товары
                    header("Location: /");
                } else {
                    // В корзине есть товары? - Да
                    // Итоги: общая стоимость, количество товаров
                    $productsIds = array_keys($productsInCart);
                    $products = Product::getProdustsByIds($productsIds);
                    $totalPrice = Cart::getTotalPrice($products);
                    $totalQuantity = Cart::countItems();


                    $userName = false;
                    $userPhone = false;
                    $userComment = false;

                    // Пользователь авторизирован?
                    if (User::isGuest()) {
                        // Нет
                        // Значения для формы пустые
                    } else {
                        // Да, авторизирован                    
                        // Получаем информацию о пользователе из БД по id
                        $userId = User::checkLogged();
                        $user = User::getUserById($userId);
                        // Подставляем в форму
                        $userName = $user['name_user'];
                        $userPhone = $user['phone_user'];
                    }
                }
            }

            require_once(ROOT . '/views/cart/checkout.php');

            return true;
        }

    }
?>
