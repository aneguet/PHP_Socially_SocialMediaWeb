<?php
session_start();
spl_autoload_register(function ($class) {
  $pathController = 'controller/' . $class . '.php';
  $pathModel = 'models/' . $class . '.php';
  $file = str_replace('\\', '/', $class) . '.php';




  if (file_exists($pathController)) {
    require_once $pathController;
  } elseif (file_exists($pathModel)) {
    require_once $pathModel;
  } elseif (file_exists('../controller/' . $class . '.php')) {
    require_once '../controller/' . $class . '.php';
  } elseif (file_exists('../models/' . $class . '.php')) {
    require_once '../models/' . $class . '.php';
  } elseif (file_exists('../../controller/' . $class . '.php')) {
    require_once '../../controller/' . $class . '.php';
  } elseif (file_exists('../../models/' . $class . '.php')) {
    require_once '../../models/' . $class . '.php';
  }
});
