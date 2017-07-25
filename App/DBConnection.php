<?php
/**
 * Created by PhpStorm.
 * User: jaime
 * Date: 24/07/17
 * Time: 23:48
 */

namespace App;


class DBConnection
{
    /**
     * @var \PDO
     */
    public $connection = null;

    /**
     * DBConnection constructor.
     */
    public function __construct()
    {
        $config = Config::getDatabaseConfig();
        if (is_null($this->connection)) {
            try {
                $this->connection = new \PDO(
                    sprintf(
                        "mysql:host=%s;dbname=%s",
                        $config->host,
                        $config->database
                    ),
                    $config->username,
                    $config->password
                );
            } catch (\PDOException $e) {
                echo "\n-------------\n";
                echo $e->getMessage();
                echo "\n-------------\n";
                exit(1);
            }
        }
    }
}