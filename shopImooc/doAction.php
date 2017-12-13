<?php
require_once 'include.php';
connect();
$act=$_REQUEST['act'];
if ($act=='reg'){
    addforUser();
}if ($act=='login'){
    login();
}if ($act=='userOut'){
    userOut();
}