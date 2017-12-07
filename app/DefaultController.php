<?php
/**
 * Created by PhpStorm.
 * User: oleg
 * Date: 03.12.17
 * Time: 17:51
 */

namespace App;

use Core\App;
use Core\View;
use Symfony\Component\HttpFoundation\Response;

class DefaultController
{
    /**
     *  Controller for 404 http error.
     */
    public function notFound()
    {
        View::view()
            ->render('404');
    }
    
    /**
     *  Controller for 500 http error.
     */
    public function internalError()
    {
        View::view()
            ->render('500');
    }
    
    /**
     * Controller for index page.
     * Now this controller redirect on "http(s)://host/task" page
     * but you can change this controller how you like for index page.
     */
    public function index()
    {
        $host = App::app()
                   ->getRequest()
                   ->getSchemeAndHttpHost();
        View::view()
            ->setHttpStatus(Response::HTTP_FOUND)
            ->getResponse()->headers->set("Location", $host.'/task/');
        
    }
}
