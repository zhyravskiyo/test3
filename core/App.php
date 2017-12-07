<?php
/**
 * Created by PhpStorm.
 * User: oleg
 * Date: 03.12.17
 * Time: 15:35
 */

/**
 * This class implement Singleton pattern.
 */

namespace Core;

use Symfony\Component\HttpFoundation\Request;

class App
{
    private static $me = null;
    
    private $request = null;
    
    private $errCodes = [404];
    
    private function __construct()
    {
        Route::route()
             ->loadRoutes();
        $this->request = Request::createFromGlobals();
    }
    
    public static function app()
    {
        if (is_null(self::$me)) {
            self::$me = new self();
        }
        
        return self::$me;
    }
    
    public function run()
    {
        $db = DB::db();
        
        try {
            $config = $this->getRoute();
            $this->runRoute($config);
        } catch (\Exception $exception) {
            $this->errorRedirect($exception);
        }
        
        View::view()
            ->getResponse()
            ->send();
    }
    
    /**
     * @return null|static
     */
    public function getRequest()
    {
        return $this->request;
    }
    
    /**
     * @param \Exception $exception
     *
     * redirect user on page what isset info for error
     */
    private function errorRedirect(\Exception $exception)
    {
        $host = $this->request->getSchemeAndHttpHost();
        $code = $exception->getCode();
        $code = $this->checkError($code);
        View::view()
            ->setHttpStatus($code)
            ->setHeader('Refresh', "0; url=".$host."/$code/");
    }
    
    /**
     * this function check if register error code in app
     *
     * @param int $code
     *
     * @return int
     */
    private function checkError(int $code)
    {
        if (in_array($code, $this->errCodes, true)) {
            return $code;
        }
        
        return 500;
    }
    
    /**
     * search route and params from uri
     *
     * @return array
     */
    private function getRoute()
    {
        $method = $this->request->getRealMethod();
        $uri = $this->request->getRequestUri();
        $route = Route::route()
                      ->findRoute($method, $uri);
        
        return $route;
    }
    
    /**
     * execute route controller with parameters
     *
     * @param $config
     */
    private function runRoute($config)
    {
        $controller = "\\App\\".$config['controller'];
        $params = array_values($config['params']);
        call_user_func($controller, ...$params);
    }
}
