<?php

$path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);


$path = str_replace("/webdev/RickJames/php-mvc-routing/", "/", parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));
// Local
// $path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

// require "src/router.php";


spl_autoload_register(function (string $class_name) {

    require "src/" . str_replace("\\", "/", $class_name) . ".php";
});

// add these lines to your code

define("ROOT_PATH", dirname(__DIR__));
// add the new WEB_ROOT definition to match the location of your project on the new server
// Change the AvatarName to the avatar name of your project folder on the new server
define("WEB_ROOT", "/webdev/RickJames/public/");

// remove the following line
// $path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
// add this line with the WEB_ROOT reference
$path = str_replace(WEB_ROOT, "", parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));

// the autoloader stays the same
spl_autoload_register(function (string $class_name) {

    require ROOT_PATH . "/src/" . str_replace("\\", "/", $class_name) . ".php";
});

$dotenv = new Framework\Dotenv;

$dotenv->load(ROOT_PATH . "/.env");


// begin adding routes to the $routes array
// $router->add("/webdev/RickJames/php-mvc-routing", ["controller" => "home", "action" => "index"]);
// $router->add("/products", ["controller" => "products", "action" => "index"]);
// $router->add("/products/show", ["controller" => "products", "action" => "show"]);
$router->add("/{controller}/{action}")
// call to matchRoute() to return an array of $params from $routes
$params = $router->matchRoute($path);

// check for non-existent route
if ($params === false) {

    exit("No matching route");

}
if ($params === false) {

    throw new PageNotFoundException("No matching route for '$path'.");
    
}

// edit these variables to assign values from $params array from Router class
$controller = $params["controller"];
$action = $params["action"];

// require "src/controllers/$controller.php";
$controller = "App\Controllers\\" . ucwords($params["controller"]);

$controller_object = new $controller;

$controller_object->$action();
declare(strict_types=1);

use Framework\Exceptions\PageNotFoundException;

// Catches error information then passes it to the ErrorException function
set_error_handler(function(
    int $errno,
    string $errstr,
    string $errfile,
    int $errline
): bool
{
    throw new ErrorException($errstr, 0, $errno, $errfile, $errline);
});

// Calls the custom exception handler
set_exception_handler(function (Throwable $exception) {

    if ($exception instanceof Framework\Exceptions\PageNotFoundException) {

        http_response_code(404);

        $template = "404.php";

    } else {
    
        http_response_code(500);

        $template = "500.php";

    }

    $show_errors = false;

    if ($show_errors) {

        ini_set("display_errors", "1");

        require ROOT_PATH . "/views/$template";

    } else {

        ini_set("display_errors", "0");

        ini_set("log_errors", "1");

        require ROOT_PATH . "/views/$template";

    }

    throw $exception;

});