<?php
/**
 * Created by PhpStorm.
 * User: xiong
 * Date: 19/05/2018
 * Time: 1:04 PM
 */
class Tool
{

    public static function test_input($data)
    {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }
}
?>