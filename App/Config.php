<?php
/**
 * Created by PhpStorm.
 * User: jaime
 * Date: 24/07/17
 * Time: 23:22
 */

namespace App;

/**
 * Class Config
 * @package App
 */
class Config
{
    /**
     * Set default path to load config
     *
     * @var string
     */
    public static $filePath = __DIR__ . "/../config/config.json";

    public static $dbConfigPath = __DIR__ . "/../config/database.json";

    public static function setConfigFilePath($filePath)
    {
        self::$filePath = $filePath;
    }

    public static function getConfig()
    {
        return json_decode(file_get_contents(self::$filePath));
    }

    public static function setDatabaseConfigFile($dbConfigPath)
    {
        self::$dbConfigPath = $dbConfigPath;
    }

    public static function getDatabaseConfig($config = null)
    {
        if (is_null($config)) {
            return json_decode(file_get_contents(self::$dbConfigPath));
        }

        return $config;
    }

}