<?php 

// declare(strict_types=1);


date_default_timezone_set("Europe/Helsinki");

function check($arr) {
  return $arr % 2;
}

$num = [1, 2, 3, 4, 6];

print_r(array_map('check', $num));














// $date = date_create_from_format("l-m-Y", "thursday-03-2020");

// echo date_format($date, "d/m/Y");

// function classAutoLoaderConfig($class) {
//   $the_path = "config/" . str_replace('\\', '/', $class) . ".php";
//    if(is_file($the_path) && !class_exists($class)) {
//        require_once($the_path);
//    } else {
//       die("The file named {$class}.php could not be found!");
//    }
// }
// spl_autoload_register('classAutoLoaderConfig');

// function classAutoLoaderController($class) {
//   $the_path = "controllers/" . str_replace('\\', '/', $class) . ".php";
//    if(is_file($the_path) && !class_exists($class)) {
//        require_once($the_path);
//    } else {
//       die("The file named {$class}.php could not be found!");
//    }
// }
// spl_autoload_register('classAutoLoaderController');

// function classAutoLoaderModel($class) {
//    $the_path = "models/" . str_replace('\\', '/', $class) . ".php";
//    if(is_file($the_path) && !class_exists($class)) {
//        require_once($the_path);
//    } else {
//       die("The file named {$class}.php could not be found!");
//    }
// }
// spl_autoload_register('classAutoLoaderModel');











