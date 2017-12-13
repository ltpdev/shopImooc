<?php
require_once '../include.php';
connect();
$username=$_POST['username'];
$password=md5($_POST['password']);
$verify=$_POST['verify'];
$verify1=$_SESSION['verify'];
$autoFlag=$_POST['autoFlag'];
if ($verify==$verify1){
    $sql="select * from imooc_admin where username='{$username}' and password='{$password}'";
    $row=checkAdmin($sql);
    if($row){
        //一周自动登录
        if ($autoFlag){
            setcookie("adminId",$row['id'],time()+7*24*3600);
            setcookie("adminName",$row['username'],time()+7*24*3600);
        }
        $_SESSION['adminName']=$row['username'];
        $_SESSION['adminId']=$row['id'];
        //header("location:index.php");
        alertMes("登陆成功","index.php");
    }else{
        alertMes('登录失败,重新登录','login.php');
    }
}else{
    alertMes('验证码错误','login.php');
}
