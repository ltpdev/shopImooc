<?php
/*connect();
$sql="select * from imooc_admin";
$toalRows=getResultNum($sql);
//echo $toalRows;
//每页显示的条数或者行数
$pageSize=2;
//总共分为几页
$toalPage=ceil($toalRows/$pageSize);
//第几页
$page=$_REQUEST['page']?(int)$_REQUEST['page']:1;
if ($page<1){
    $page=1;
}
if ($page>=$toalPage||$page==null||!is_numeric($page)){
    $page=$toalPage;
}
echo $_REQUEST['page'];
//当前偏移量，也就是从哪行开始返回
$offset=($page-1)*$pageSize;
$sql="select * from imooc_admin limit {$offset},{$pageSize}";

$rows=fetchAll($sql);
foreach($rows as $row) {
    echo "编号：".$row['id']."<br>";
    echo "管理员的名称：".$row['username']."<hr>";
}*/
/*echo showPage($page,$toalPage);
echo "<hr/>";
echo showPage($page,$toalPage,"cid=5");*/
function showPage($page,$toalPage,$where=null,$sep="&nbsp;"){
    $where=($where==null)?null:"&".$where;
    $url = $_SERVER['PHP_SELF'];
    $index = ($page == 1) ? "首页" : "<a href='{$url}?page=1{$where}'>首页</a>";
    $last = ($page == $toalPage) ? "尾页" : "<a href='{$url}?page={$toalPage}{$where}'>尾页</a>";
    $prev = ($page == 1) ? "上一页" : "<a href='{$url}?page=" . ($page - 1) . "{$where}'>上一页</a>";
    $next = ($page == $toalPage) ? "下一页" : "<a href='{$url}?page=" . ($page + 1) ."{$where}'>下一页</a>";
    $str = "总共{$toalPage}页/当前是第{$page}页";
    $p="";
    for ($i = 1; $i <= $toalPage; $i++) {
        if ($i == $page) {
            $p .= "[{$i}]";
        } else {
            $p .= "<a href='{$url}?page={$i}'>[{$i}]</a>";
        }
    }
    $pageStr=$str.$sep.$index.$sep.$prev.$sep.$p.$sep.$next.$sep.$last;
    return $pageStr;
}