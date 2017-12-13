<?php
function addPro()
{
    $arr = $_POST;
    $arr['pubTime'] = time();
    $path = "./uploads";
    $uploadFiles = uploadFile($path);
    if (is_array($uploadFiles) && $uploadFiles) {
        foreach ($uploadFiles as $key => $uploadFile) {
            //生成相应的缩略图
            thumb($path . "/" . $uploadFile['name'], "../image_50/" . $uploadFile['name'], 50, 50);
            thumb($path . "/" . $uploadFile['name'], "../image_220/" . $uploadFile['name'], 220, 220);
            thumb($path . "/" . $uploadFile['name'], "../image_350/" . $uploadFile['name'], 350, 350);
            thumb($path . "/" . $uploadFile['name'], "../image_800/" . $uploadFile['name'], 800, 800);
        }
    }
    //往imooc_pro表插入数据
    $res = insert("imooc_pro", $arr);
    $pid = getInsertId();
    if ($res && $pid) {
        //imooc_pro表插入数据成功的话往imooc_album插入数据
        if (is_array($uploadFiles) && $uploadFiles) {
            foreach ($uploadFiles as $key => $uploadFile) {
                //往imooc_album表插入数据
                $arr1["pid"] = $pid;
                $arr1["albumPath"] = $uploadFile['name'];
                addAlbum($arr1);
            }
        }
        $mes = "<p>添加成功!</p><a href='addPro.php' target='mainFrame'>继续添加</a>|<a href='listPro.php' target='mainFrame'>查看商品列表</a>";
    } else {
        //imooc_pro表插入数据不成功的话则删掉相应的缩略图
        if (is_array($uploadFiles) && $uploadFiles) {
            foreach ($uploadFiles as $key => $uploadFile) {
                if (file_exists("../image_800/" . $uploadFile['name'])) {
                    unlink("../image_800/" . $uploadFile['name']);
                }
                if (file_exists("../image_50/" . $uploadFile['name'])) {
                    unlink("../image_50/" . $uploadFile['name']);
                }
                if (file_exists("../image_220/" . $uploadFile['name'])) {
                    unlink("../image_220/" . $uploadFile['name']);
                }
                if (file_exists("../image_350/" . $uploadFile['name'])) {
                    unlink("../image_350/" . $uploadFile['name']);
                }
            }
        }
        $mes = "<p>添加失败!</p><a href='addPro.php' target='mainFrame'>重新添加</a>";
    }

    return $mes;
}

function getAllPro()
{
    $sql = "select p.id,p.pName,p.pSn,p,pNum,p.mPrice,p.iPrice,p.pDesc,p.pubTime,p.isShow,p.isHot,c.cName from imooc_pro as p join imooc_cate c on p.cId=c.id";
    $rows = fetchAll($sql);
    return $rows;

}

function getProByPage($pageSize = 2,$where=null,$orderBy=null)
{
    $sql = "select p.id,p.pName,p.pSn,p.pNum,p.mPrice,p.iPrice,p.pDesc,p.pubTime,p.isShow,p.isHot,c.cName from imooc_pro as p join imooc_cate c on p.cId=c.id {$where}{$orderBy}";
    $toalRows = getResultNum($sql);
//echo $toalRows;
//每页显示的条数或者行数
//总共分为几页
    global $toalPage;
    $toalPage = ceil($toalRows / $pageSize);
//第几页
    global $page;
    $page = $_REQUEST['page'] ? (int)$_REQUEST['page'] : 1;
    if ($page < 1) {
        $page = 1;
    }
    if ($page >= $toalPage || $page == null || !is_numeric($page)) {
        $page = $toalPage;
    }
//当前偏移量，也就是从哪行开始返回
    $offset = ($page - 1) * $pageSize;
    $sql = "select p.id,p.pName,p.pSn,p.pNum,p.mPrice,p.iPrice,p.pDesc,p.pubTime,p.isShow,p.isHot,c.cName from imooc_pro as p join imooc_cate c on p.cId=c.id {$where}{$orderBy} limit {$offset},{$pageSize}";
    $rows = fetchAll($sql);
    return $rows;
}

function getProImageByPid($pId)
{
    $sql = "select albumPath from imooc_album where pid={$pId}";
    $rows = fetchAll($sql);
    return $rows;
}

function getProImgById($pId){
    $sql = "select albumPath from imooc_album where pid={$pId} limit 1";
    $row= fetchOne($sql);
    return $row;
}
function getProImgsById($id){
    $sql = "select albumPath from imooc_album where pid={$id}";
    $rows= fetchAll($sql);
    return $rows;
}


function getProById($id)
{
    $sql = "select p.id,p.pName,p.pSn,p.pNum,p.mPrice,p.iPrice,p.pDesc,p.pubTime,p.isShow,p.isHot,c.cName,p.cId from imooc_pro as p join imooc_cate c on p.cId=c.id where p.id={$id}";
    $row = fetchOne($sql);
    return $row;
}

function editPro($id){
    $arr = $_POST;
    $path = "./uploads";
    $uploadFiles = uploadFile($path);
    if (is_array($uploadFiles) && $uploadFiles) {
        foreach ($uploadFiles as $key => $uploadFile) {
            //生成相应的缩略图
            thumb($path . "/" . $uploadFile['name'], "../image_50/" . $uploadFile['name'], 50, 50);
            thumb($path . "/" . $uploadFile['name'], "../image_220/" . $uploadFile['name'], 220, 220);
            thumb($path . "/" . $uploadFile['name'], "../image_350/" . $uploadFile['name'], 350, 350);
            thumb($path . "/" . $uploadFile['name'], "../image_800/" . $uploadFile['name'], 800, 800);
        }
    }
    $where="id={$id}";
    $res = update("imooc_pro", $arr,$where);
    $pid = $id;
    if ($res && $pid) {
        //imooc_pro表插入数据成功的话往imooc_album插入数据
        if (is_array($uploadFiles) && $uploadFiles) {
            foreach ($uploadFiles as $key => $uploadFile) {
                //往imooc_album表插入数据
                $arr1["pid"] = $pid;
                $arr1["albumPath"] = $uploadFile['name'];
                addAlbum($arr1);
            }
        }
            $mes = "<p>编辑成功!</p><a href='listPro.php' target='mainFrame'>查看商品列表</a>";

    } else {
        //imooc_pro表插入数据不成功的话则删掉相应的缩略图
        if (is_array($uploadFiles) && $uploadFiles) {
            foreach ($uploadFiles as $key => $uploadFile) {
                if (file_exists("../image_800/" . $uploadFile['name'])) {
                    unlink("../image_800/" . $uploadFile['name']);
                }
                if (file_exists("../image_50/" . $uploadFile['name'])) {
                    unlink("../image_50/" . $uploadFile['name']);
                }
                if (file_exists("../image_220/" . $uploadFile['name'])) {
                    unlink("../image_220/" . $uploadFile['name']);
                }
                if (file_exists("../image_350/" . $uploadFile['name'])) {
                    unlink("../image_350/" . $uploadFile['name']);
                }
            }
        }
        $mes = "<p>编辑失败!</p><a href='editPro.php' target='mainFrame'>重新编辑</a>";
    }

    return $mes;
}
function delPro($id){
    $where="id={$id}";
    $res=delete("imooc_pro",$where);
    $proImgs=getProImageByPid($id);
    if ($proImgs&&is_array($proImgs)){
        foreach ($proImgs as $proImg){
            if (file_exists("../admin/uploads/".$proImg['albumPath'])){
                unlink("../admin/uploads/".$proImg['albumPath']);
            }
            if (file_exists("../image_50/".$proImg['albumPath'])){
                unlink("../image_50/".$proImg['albumPath']);
            }
            if (file_exists("../image_220/".$proImg['albumPath'])){
                unlink("../image_220/".$proImg['albumPath']);
            }
            if (file_exists("../image_350/".$proImg['albumPath'])){
                unlink("../image_350/".$proImg['albumPath']);
            }
            if (file_exists("../image_800/".$proImg['albumPath'])){
                unlink("../image_800/".$proImg['albumPath']);
            }

        }
    }
    $where1="pid={$id}";
    $res1=delete("imooc_album",$where1);
    if ($res&&$res1){
        $mes = "<p>删除成功!</p><a href='listPro.php' target='mainFrame'>查看商品列表</a>";
    }else{
        $mes = "<p>删除失败!</p><a href='listPro.php' target='mainFrame'>重新删除</a>";
    }
    return $mes;
}

function getProsByCid($cId){
    $sql = "select p.id,p.pName,p.pSn,p.pNum,p.mPrice,p.iPrice,p.pDesc,p.pubTime,p.isShow,p.isHot,c.cName,p.cId from imooc_pro as p join imooc_cate c on p.cId=c.id where p.cId={$cId} limit 4";
    $rows = fetchAll($sql);
    return $rows;
}
function getSmallProsByCid($cId){
    $sql = "select p.id,p.pName,p.pSn,p.pNum,p.mPrice,p.iPrice,p.pDesc,p.pubTime,p.isShow,p.isHot,c.cName,p.cId from imooc_pro as p join imooc_cate c on p.cId=c.id where p.cId={$cId} limit 4";
    $rows = fetchAll($sql);
    return $rows;
}

/**
 *得到商品ID和商品名称
 * @return array
 */
function getProInfo(){
    $sql="select id,pName from imooc_pro order by id asc";
    $rows=fetchAll($sql);
    return $rows;
}