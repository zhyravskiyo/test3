<?php
/**
 * Created by PhpStorm.
 * User: oleg
 * Date: 03.12.17
 * Time: 15:20
 */

define("BASE_PATH", __DIR__."/../");

require_once BASE_PATH."vendor/autoload.php";

Core\App::app()
        ->run();
