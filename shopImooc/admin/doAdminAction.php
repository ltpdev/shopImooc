<?php
require_once '../include.php';
connect();
$act=$_REQUEST['act'];
$id=$_REQUEST['id'];
if ($act=='logout'){
    logout();
}elseif ($act=='addAdmin'){
    $mess=addAdmin();
}elseif ($act=='editAdmin'){
    $mess=editAdmin($id);
}elseif ($act=='delAdmin'){
    $mess=delAdmin($id);
}elseif($act=='addCate'){
    $mess=addCate();
}elseif($act=='editCate'){
    $mess=editCate($id);
}elseif($act=='delCate'){
    $mess=delCate($id);
}elseif($act=='addPro'){
    $mess=addPro();
}elseif($act=='editPro'){
    $mess=editPro($id);
}elseif($act=='delPro'){
    $mess=delPro($id);
}elseif($act=='addUser'){
    $mess=addUser();
}elseif($act=='delUser'){
    $mess=delUser($id);
}elseif($act=='editUser'){
    $mess=editUser($id);
}elseif($act=='waterText'){
    $mess=doWaterText($id);
}elseif($act=='waterPic'){
    $mess=doWaterPic($id);
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
    <meta charset="utf-8">
    <title></title>
</head>
<body>
<?php
if ($mess){
    echo $mess;
}
?>
</body>
</html>