<?php
/**
 * Created by PhpStorm.
 * User: oleg
 * Date: 04.12.17
 * Time: 6:06
 */

/**
 * This class implement Singleton pattern.
 */

namespace Core;


use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Tools\Setup;

class DB
{
    private static $me = null;
    
    private $entityManager = null;
    
    private function __construct()
    {
        include_once BASE_PATH . "config/db.php";
        $config = Setup::createAnnotationMetadataConfiguration([BASE_PATH . 'app'], true);
        $this->entityManager = EntityManager::create($connectionConfig,$config);
    }
    
    public static function db(){
        if (is_null(self::$me)){
            self::$me = new self();
        }
        
        return self::$me;
    }
}
