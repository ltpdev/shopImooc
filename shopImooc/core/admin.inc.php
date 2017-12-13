<?php
/*检查是否管理员*/
function checkAdmin($sql){
    return fetchOne($sql);
}
/*检查是否登录过*/
function checkLogined(){
    if ($_SESSION['adminId']=="" && $_COOKIE['adminId']==""){
        alertMes("还没登录，请先登录","login.php");
    }
}
/*注销登录*/
function logout(){
  $_SESSION=array();
  //判断是否为空
  if (isset($_COOKIE[session_name()])){
      setcookie(session_name(),"",time()-1);
      echo "<script>alert('haha')</script>";
  }
    if (isset($_COOKIE['adminId'])){
        setcookie('adminId',"",time()-1);
    }
    if (isset($_COOKIE['adminName'])){
        setcookie('adminName',"",time()-1);
    }
  session_destroy();
  header("location:login.php");
}
/*添加管理员*/
function addAdmin(){
    $arr=$_POST;
    $arr['password']=md5($_POST['password']);
    if (insert("imooc_admin",$arr)){
        $mess="添加成功!<br/><a href='addAdmin.php'>继续添加</a>|<a href='listAdmin.php'>查看管理员</a>";
    }else{
        $mess="添加失败!<br/><a href='addAdmin.php'>重新添加</a>";
    }
    return $mess;
}
/*得到所有管理员*/
function getAllAdmin(){
    $sql="select id,username,email from imooc_admin";
    $rows=fetchAll($sql);
    return $rows;
}
/*编辑管理员*/
function editAdmin($id){
    $arr=$_POST;
    $arr['password']=md5($_POST['password']);
    if (update("imooc_admin",$arr,"id={$id}")){
        $mess="编辑成功!<br/><a href='listAdmin.php'>查看管理员列表</a>";
    }else{
        $mess="编辑失败!<br/><a href='listAdmin.php'>请重新修改</a>";
    }
    return $mess;
}

/*删除管理员*/
function delAdmin($id){
    if (delete("imooc_admin","id={$id}")){
        $mess="删除成功!<br/><a href='listAdmin.php'>查看管理员列表</a>";
    }else{
        $mess="删除失败!<br/><a href='listAdmin.php'>请重新删除</a>";
    }
    return $mess;
}

function getAdminByPage($pageSize=2){
    $sql="select * from imooc_admin";
    $toalRows=getResultNum($sql);
//echo $toalRows;
//每页显示的条数或者行数
//总共分为几页
    global $toalPage;
    $toalPage=ceil($toalRows/$pageSize);
//第几页
    global $page;
    $page=$_REQUEST['page']?(int)$_REQUEST['page']:1;
    if ($page<1){
        $page=1;
    }
    if ($page>=$toalPage||$page==null||!is_numeric($page)){
        $page=$toalPage;
    }
//当前偏移量，也就是从哪行开始返回
    $offset=($page-1)*$pageSize;
    $sql="select * from imooc_admin limit {$offset},{$pageSize}";
    $rows=fetchAll($sql);
    return $rows;
}


/**
 * 添加用户的操作
 * @param int $id
 * @return string
 */
function addUser(){
    $arr=$_POST;
    $arr['password']=md5($_POST['password']);
    $arr['regTime']=time();
    $uploadFile=uploadFile("../uploads");
    if($uploadFile&&is_array($uploadFile)){
        $arr['face']=$uploadFile[0]['name'];
    }else{
        return "添加失败<a href='addUser.php'>重新添加</a>";
    }
    if(insert("imooc_user", $arr)){
        $mes="添加成功!<br/><a href='addUser.php'>继续添加</a>|<a href='listUser.php'>查看列表</a>";
    }else{
        $filename="../uploads/".$uploadFile[0]['name'];
        if(file_exists($filename)){
            unlink($filename);
        }
        $mes="添加失败!<br/><a href='addUser.php'>重新添加</a>|<a href='listUser.php'>查看列表</a>";
    }
    return $mes;
}

function delUser($id){
    $sql="select face from imooc_user WHERE id={$id}";
    $row=fetchOne($sql);
    $face=$row['face'];
    if (file_exists("../uploads/".$face)){
        unlink("../uploads/".$face);
    }
    if (delete("imooc_user","id={$id}")){
        $mes="删除成功!<br/><a href='listUser.php'>查看用户列表</a>";
    }else{
        $mes="删除失败!<br/><a href='listUser.php'>请重新删除</a>";
    }
    return $mes;
}

function editUser($id){
    $arr=$_POST;
    $arr['password']=md5($_POST['password']);
    if (update("imooc_user",$arr,"id={$id}")){
        $mess="编辑成功!<br/><a href='listUser.php'>查看管理员列表</a>";
    }else{
        $mess="编辑失败!<br/><a href='listUser.php'>请重新修改</a>";
    }
    return $mess;
}
