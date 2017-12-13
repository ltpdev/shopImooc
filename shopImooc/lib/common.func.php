<?php
/**
 * Created by PhpStorm.
 * User: asus-
 * Date: 2017/7/25
 * Time: 9:53
 */
function alertMes($mes,$url){
    echo "<script>alert('{$mes}')</script>";
    echo "<script>window.location='{$url}';</script>";
}