<?php
/**
 * Created by PhpStorm.
 * User: oleg
 * Date: 03.12.17
 * Time: 15:42
 */

/**
 * For more information see https://github.com/nikic/FastRoute .
 */
$routeCollector->get("/", "DefaultController::index");

$routeCollector->get("/404/", "DefaultController::notFound");

$routeCollector->get("/500/", "DefaultController::internalError");

$routeCollector->get("/task/", "TaskController::show");

$routeCollector->post("/task/", "TaskController::create");

$routeCollector->put("/task/{id:[0-9]*}/", "TaskController::update");

$routeCollector->get("/task/{page:[0-9]*}/{count:[0-9]*}/{field}/{condition}/", "TaskController::list");

$routeCollector->post("/user/login/", "UserController::login");

$routeCollector->get("/user/logout/", "UserController::logout");
