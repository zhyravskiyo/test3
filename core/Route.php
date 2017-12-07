<?php
/**
 * Created by PhpStorm.
 * User: oleg
 * Date: 03.12.17
 * Time: 15:38
 */

/**
 * This class implement Singleton pattern.
 */

namespace Core;

use FastRoute\Dispatcher;
use FastRoute\RouteCollector;
use function FastRoute\simpleDispatcher;

class Route
{
    const ROUTE_CONFIG_PATH = BASE_PATH."config/routes.php";
    
    private static $me = null;
    
    private $dispatcher = null;
    
    private function __construct()
    {
    }
    
    public static function route()
    {
        if (is_null(self::$me)) {
            self::$me = new self();
        }
        
        return self::$me;
    }
    
    /**
     * Register routes from config.
     *
     * @return $this
     */
    public function loadRoutes()
    {
        $this->dispatcher = simpleDispatcher(
            function (RouteCollector $routeCollector) {
                include_once self::ROUTE_CONFIG_PATH;
            }
        );
        
        return $this;
    }
    
    /**
     * Search route from uri and method, and parse uri params.
     *
     * @param string $httpMethod
     * @param string $uri
     *
     * @return array
     * @throws \Exception
     */
    public function findRoute(string $httpMethod, string $uri)
    {
        $uri = rawurldecode($uri);
        
        $info = $this->dispatcher->dispatch($httpMethod, $uri);
        
        switch ($info[0]) {
            case Dispatcher::NOT_FOUND:
                throw new \Exception('not found url', 404);
            case Dispatcher::METHOD_NOT_ALLOWED:
                throw new \Exception('this method not allowed', 405);
            case Dispatcher::FOUND:
                return [
                    'controller' => $info[1],
                    'params'     => $info[2],
                ];
        }
        
        throw new \Exception("unexpected error in Core\\Route class");
    }
}
