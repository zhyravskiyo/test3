<?php
/**
 * Created by PhpStorm.
 * User: oleg
 * Date: 03.12.17
 * Time: 17:04
 */

/**
 * This class implement Singleton pattern.
 */

namespace Core;

use Symfony\Component\HttpFoundation\Response;

class View
{
    const VIEWS_PATH = BASE_PATH."views/";
    
    const HTML_TYPE = "text/html";
    
    const JSON_TYPE = "application/json";
    
    private static $me = null;
    
    private $response = null;
    
    private function __construct()
    {
        $this->response = new Response();
        $request = App::app()
                      ->getRequest();
        $this->response->prepare($request);
    }
    
    public static function view()
    {
        if (is_null(self::$me)) {
            self::$me = new self();
        }
        
        return self::$me;
    }
    
    /**
     * @param string $key
     * @param string $value
     *
     * @return $this
     */
    public function setHeader(string $key, string $value)
    {
        $this->response->headers->set($key, $value);
        
        return $this;
    }
    
    /**
     * @param int $statusCode
     *
     * @return $this
     */
    public function setHttpStatus(int $statusCode)
    {
        $this->response->setStatusCode($statusCode);
        
        return $this;
    }
    
    /**
     * Set content for response from view file or from array to json
     *
     * @param string $view
     * @param array  $params
     *
     * @return $this
     * @throws \Exception
     */
    public function render(string $view, array $params = [])
    {
        if ($view === 'json') {
            $this->response->headers->set('Content-Type', 'application/json');
            $this->response->setContent(json_encode($params));
        } elseif (file_exists($file_path = self::VIEWS_PATH.$view.".html")) {
            $data = file_get_contents($file_path);
            $this->response->setContent($data);
        } else {
            throw new \Exception("not isset view", 404);
        }
        
        return $this;
    }
    
    /**
     * @return null|\Symfony\Component\HttpFoundation\Response
     */
    public function getResponse()
    {
        return $this->response;
    }
}
