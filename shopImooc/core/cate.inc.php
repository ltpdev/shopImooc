<?php
function addCate(){
    $arr=$_POST;
    if (insert("imooc_cate",$arr)){
        $mess="添加成功!<br/><a href='addCate.php'>继续添加</a>|<a href='listCate.php'>查看分类列表</a>";
    }else{
        $mess="添加失败!<br/><a href='addCate.php'>重新添加</a>";
    }
    return $mess;
}
function getCateByPage($pageSize=2){
    $sql="select * from imooc_cate";
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
    $sql="select * from imooc_cate ORDER BY id ASC limit {$offset},{$pageSize}";
    $rows=fetchAll($sql);
    return $rows;
}
function editCate($id){
    $arr=$_POST;
    if (update("imooc_cate",$arr,"id={$id}")){
        $mess="编辑成功!<br/><a href='listCate.php'>查看分类列表</a>";
    }else{
        $mess="编辑失败!<br/><a href='listCate.php'>请重新修改</a>";
    }
    return $mess;
}

function delCate($id){
    $res=checkProExists($id);
    if (!$res){
    if (delete("imooc_cate","id={$id}")){
        $mess="删除成功!<br/><a href='listCate.php'>查看分类列表</a>";
    }else{
        $mess="删除失败!<br/><a href='listCate.php'>请重新删除</a>";
    }
    }else{
        alertMes("先删除该分类下的所有产品，再删除该分类","listPro.php");
    }
    return $mess;
}
function getAllCate(){
    $sql="select * from imooc_cate";
    $rows=fetchAll($sql);
    return $rows;
}
/*检查该分类下是否有产品*/
function checkProExists($cId){
    $sql="select * from imooc_pro where cId={$cId}";
    $rows=fetchAll($sql);
    return $rows;
}