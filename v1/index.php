<?php 

declare(strict_types=1);

date_default_timezone_set("Europe/Helsinki");

$array = ['name' => 'Sola', 'age' => 48, 'school' => 'African Church Grammar School', 'town' => '', 'profession' => ''];

function notAvail($empty) {
  return $empty != null;
}

print_r(array_filter($array, 'notAvail'));




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











