<?php
    class Router {
        
        private $routes;

        public function __construct() {
            $routesPath = ROOT . '/configs/routes.php';
            $this->routes = include($routesPath);
        }

        // метод возвращает строку запроса uri
        private function getURI() {
            if(!empty($_SERVER['REQUEST_URI'])) {
                return trim($_SERVER['REQUEST_URI'], '/');
            }
        }

        public function run() {
            // Получить строку запроса

            $uri = $this->getURI();
            // Проверить наличие такого запроса в routes.php

            $i = 0;
            $result = null;
            foreach ($this->routes as $uriPattern => $path) {
                // Сравнение uriPattern и uri
                if(preg_match("~$uriPattern~", $uri)) {
                    $internalRoute = preg_replace("~$uriPattern~", $path, $uri);
                    $segments = explode('/', $internalRoute);

                    // Если есть совпадения, определить какой контроллер
                    // и action обрабатывают запрос

                    $controllerName = array_shift($segments) . 'Controller';
                    $controllerName = ucfirst($controllerName);
                    $actionName = 'action' . ucfirst(array_shift($segments));
                    $parameters = $segments;
                    
                    // Подключить файл класса контроллера

                    $controllerFile = ROOT . '/controllers/' . $controllerName . '.php';
                    
                    if(file_exists($controllerFile)) {
                        include_once($controllerFile);
                    }

                    // Создать объект. Вызвать метод, т.е. action.

                    $controllerObject = new $controllerName;
                    //$result = $controllerObject->$actionName($parameters);
                    
                    //if($controllerName != 'AdminController' && $actionName != 'actionProduct') {
                        $result = call_user_func_array(array($controllerObject, $actionName), $parameters);
                    //}
                    
                    if ($result != null) {
                        break;
                    }   
                    
                }

            }
        }
    }
?>