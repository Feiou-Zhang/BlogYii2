<?php
/**
 * Created by PhpStorm.
 * User: feiouzhang
 * Date: 5/17/17
 * Time: 6:28 PM
 */
class self_test {
    static $food   ;

    public function eat(){
        self::$food = "dumplings";

    }
}echo $str -> eat();