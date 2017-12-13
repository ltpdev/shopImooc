<?php
function addAlbum($arr){
    insert("imooc_album",$arr);
}

function doWaterText($id){
    $rows=getProImgsById($id);
    foreach($rows as $row){
        $filename="../image_800/".$row['albumPath'];
        waterText($filename);
    }
    $mes="操作成功";
    return $mes;
}

/**
 *图片水印
 * @param int $id
 * @return string
 */
function doWaterPic($id){
    $rows=getProImgsById($id);
    foreach($rows as $row){
        $filename="../image_800/".$row['albumPath'];
        waterPic($filename);
    }
    $mes="操作成功";
    return $mes;
}