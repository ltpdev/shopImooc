<?php
//多文件或者单文件混合上传构建信息
function buildInfo(){
    if (!$_FILES){
        return;
    }
    $i=0;
    foreach ($_FILES as $v){
        //单文件
        if (is_string($v['name'])){
            $files[$i]=$v;
            $i++;
            //多文件
        }else{
            foreach ($v['name'] as $key=>$val){
                $files[$i]['name']=$val;
                $files[$i]['size']=$v['size'][$key];
                $files[$i]['tmp_name']=$v['tmp_name'][$key];
                $files[$i]['error']=$v['error'][$key];
                $files[$i]['type']=$v['type'][$key];
                $i++;
            }
        }
    }

    return $files;
}

function uploadFile($path="uploads",$allowExt = array("gif", "jpeg", "jpg", "png", "wbmp"),$maxSize=1512000,$imgFlag=true){
    $files=buildInfo();
    if (!($files&&is_array($files))){
        return;
    }
    $i=0;
    foreach ($files as $fileInfo){
        if ($fileInfo['error']== UPLOAD_ERR_OK) {
            //判断文件是否通过http post方式上传上来的
            $ext = getExt($fileInfo['name']);
            //限制上传文件类型
            if (!in_array($ext, $allowExt)) {
                exit ("非法文件类型");
            }
            if ($fileInfo['size'] > $maxSize) {
                exit ("文件过大");
            }
            if($imgFlag){
                //如何验证图片是否是一个真正的图片类型
                //getimagesize($filename):验证文件是否是图片类型
                $info=getimagesize($fileInfo['tmp_name']);
                //var_dump($info);exit;
                if(!$info){
                    exit("不是真正的图片类型");
                }
            }

            if (!file_exists($path)){
                mkdir($path,0777,true);
            }
            $filename = getUniName() . "." . $ext;
            $destination = $path."/".$filename;
            if (is_uploaded_file($fileInfo['tmp_name'])) {
                if (move_uploaded_file($fileInfo['tmp_name'], $destination)) {
                    $mess = "文件上传成功";
                    $fileInfo['name']=$filename;
                    unset($fileInfo['error'],$fileInfo['tmp_name'],$fileInfo['size'],$fileInfo['type']);
                    $uploadedFiles[$i]=$fileInfo;
                    $i++;
                } else {
                    $mess = "文件移动失败";
                }
            } else {
                $mess = "不是通过http post方式上传上来的";
            }

        } else {
            switch ($fileInfo['error']) {
                case 1:
                    $mess = "超过了配置文件上传文件的大小";//UPLOAD_ERR_INI_SIZE
                    break;
                case 2:
                    $mess = "超过了表单设置上传文件的大小";//UPLOAD_ERR_FORM_SIZE
                    break;
                case 3:
                    $mess = "文件部分被上传";//UPLOAD_ERR_PARTIAL
                    break;
                case 4:
                    $mess = "没有文件被上传/你没有选择上传文件";//UPLOAD_ERR_NO_FILE
                    break;
                case 6:
                    $mess = "没有找到临时目录";//UPLOAD_ERR_NO_TMP_DIR
                    break;
                case 7:
                    $mess = "文件不可写";//UPLOAD_ERR_CANT_WRITE
                    break;
                case 8:
                    $mess = "由于PHP的扩展程序中断了上传";//UPLOAD_ERR_EXTENSION
                    break;
            }
        }
        //echo $mess;
    }
    //返回图片名字集合
    return $uploadedFiles;
}
