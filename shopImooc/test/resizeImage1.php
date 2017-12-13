<?php
require_once "../lib/string.func.php";
$filename="des_big.jpg";
/*//创建画布
list($src_w,$src_h,$imagetype)=getimagesize($filename);
$mine=image_type_to_mime_type($imagetype);
$createfun=str_replace("/","createfrom",$mine);
$outFun=str_replace("/",null,$mine);
$src_image=$createfun($filename);
//创建50*50的画布
$dst_50_image=imagecreatetruecolor(50,50);
//创建220*220的画布
$dst_220_image=imagecreatetruecolor(220,220);
//创建350*350的画布
$dst_350_image=imagecreatetruecolor(350,350);
//创建800*800的画布
$dst_800_image=imagecreatetruecolor(800,800);
//重采样并复制
imagecopyresampled($dst_50_image,$src_image,0,0,0,0,50,50,$src_w,$src_h);
header("content-type:image/jpeg");
$outFun($dst_50_image);*/


thumb($filename,"images_50/".$filename,100,100,true);
function thumb($filename,$destination=null,$dst_w=null,$dst_h=null,$isReservedSource=false,$scale=0.5){
    list($src_w,$src_h,$imagetype)=getimagesize($filename);
    if (is_null($dst_w)||is_null($dst_h)){
        $dst_w=ceil($src_w*$scale);
        $dst_h=ceil($src_h*$scale);
    }
    $mine=image_type_to_mime_type($imagetype);
    $createfun=str_replace("/","createfrom",$mine);
    $outFun=str_replace("/",null,$mine);
    $src_image=$createfun($filename);
    $dst_image=imagecreatetruecolor($dst_w,$dst_h);
    imagecopyresampled($dst_image,$src_image,0,0,0,0,$dst_w,$dst_h,$src_w,$src_h);
    if ($destination&&!file_exists(dirname($destination))){
        mkdir(dirname($destination),0777,true);
    }
    $dstFilename=$destination==null?getUniName().".".getExt($filename):$destination;
    $outFun($dst_image,$dstFilename);
    imagedestroy($src_image);
    imagedestroy($dst_image);
    if (!$isReservedSource){
        //删掉原文件
        unlink($filename);
    }
    return $dstFilename;
}

