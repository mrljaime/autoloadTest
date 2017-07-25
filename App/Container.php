<?php
/**
 * Created by PhpStorm.
 * User: jaime
 * Date: 24/07/17
 * Time: 23:48
 */

namespace App;


class Container
{
    public $dbConnection;

    public function __construct()
    {
        $this->dbConnection = new DBConnection();
    }

}