<?php

namespace application\core;

class Router {
    protected $routes = [];
    protected $parms = [];
    function __construct() {
       $arr = require 'application/config/routes.php';
       foreach ($arr as $key => $val) {
           $this -> add($key, $val);
       }
    }
    
    function add($route, $params) {
        $route = '#^'. $route. '$#';
        $this-> routes[$route] = $params;
    }
    
    function match() {
       $url = trim (filter_input(INPUT_SERVER, 'REQUEST_URI'), '/');
       foreach ($this->routes as $route => $params) {
           if (preg_match($route, $url, $matches)){
               $this->params = $params;
               return true;
           }
       }
       return false;
    }
    
    function run() {
      if ($this ->match()) {
          $controller = 'application\controllers\\'. ucfirst($this -> params['controller']). 'Controller.php';
          if (class_exists($controller)){
              echo 'OK';
          } else {
              echo 'Не найден: ' . $controller;
          }
    } else {
        echo 'marshryt ne naiden';
    }
}
}
