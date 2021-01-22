<?php
    class ProductController {

        public function actionView() {
            require_once(ROOT . '/views/products/view.php');

            return true;
        }
    }
?>