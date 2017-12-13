<?php
function addforUser(){
    $arr=$_POST;
    $arr['password']=md5($_POST['password']);
    $arr['regTime']=time();
    $uploadFile=uploadFile("../uploads");
    if($uploadFile&&is_array($uploadFile)){
        $arr['face']=$uploadFile[0]['name'];
    }else{
       alertMes("注册失败","./reg.php");
       return;
    }
    if(insert("imooc_user", $arr)){
        alertMes("注册成功","./login.php");
    }else{
        $filename="../uploads/".$uploadFile[0]['name'];
        if(file_exists($filename)){
            unlink($filename);
        }
        alertMes("注册失败","./reg.php");
    }
}

function login(){
    $username=$_POST['username'];
    $password=md5($_POST['password']);
    $username=addslashes($username);
    $autoFlag=$_POST['auto'];
        $sql="select * from imooc_user where username='{$username}' and password='{$password}'";
        $row=checkUser($sql);
        if($row){
            //一周自动登录
            if ($autoFlag){
                setcookie("userId",$row['id'],time()+7*24*3600);
                setcookie("userName",$row['username'],time()+7*24*3600);
            }
            $_SESSION['userName']=$row['username'];
            $_SESSION['userId']=$row['id'];
            alertMes("登陆成功","./index.php");
        }else{
            alertMes('登录失败,重新登录','./login.php');
        }

}




 function checkUser($sql){
    return fetchOne($sql);
}
function checkUserLogined(){
    if ($_SESSION['userId']=="" && $_COOKIE['userId']==""){
        return false;
    }
    return true;
}

function userOut(){
    $_SESSION['userName']="";
    $_SESSION['userId']="";
    //判断是否为空
   /* if (isset($_COOKIE[session_name()])){
        setcookie(session_name(),"",time()-1);
        echo "<script>alert('haha')</script>";
    }*/
    if (isset($_COOKIE['userId'])){
        setcookie('userId',"",time()-1);
    }
    if (isset($_COOKIE['userName'])){
        setcookie('userName',"",time()-1);
    }
    session_destroy();
    header("location:login.php");
}