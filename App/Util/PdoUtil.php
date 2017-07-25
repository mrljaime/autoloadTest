<?php
/**
 * Created by PhpStorm.
 * User: jaime
 * Date: 25/07/17
 * Time: 00:11
 */

namespace App\Util;


class PdoUtil
{
    public static function selectPrepared($conn, $stmt, array $params = null)
    {
        $pstmt = $conn->prepare($stmt);
        if (!is_null($params)) {
            $paramsLen = count($params);
            for ($i = 0; $i < $paramsLen; $i++) {
                $pstmt->bind($i + 1, $params[$i]);
            }
        }

        $pstmt->execute();

        return $pstmt->fetchAll();
    }
}