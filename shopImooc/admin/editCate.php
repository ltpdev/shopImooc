<?php
require_once '../include.php';
connect();
$id=$_REQUEST['id'];
$sql="select * from imooc_cate where id='{$id}'";
$row=fetchOne($sql);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
    <meta charset="utf-8">
    <title>-.-</title>
</head>
<body>
<h3>编辑分类</h3>
<form action="doAdminAction.php?act=editCate&id=<?php echo $id;?>" method="post">
    <table width="70%" border="1" cellpadding="5" cellspacing="0" bgcolor="#cccccc">
        <tr>
            <td align="right">分类名称</td>
            <td><input type="text" name="cName" placeholder="<?php echo $row['cName']?>"/></td>
        </tr>
        <tr>
            <td colspan="2"><input type="submit" value="编辑分类" /></td>
        </tr>
    </table>
</form>
</body>
</html>