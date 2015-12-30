<?php
$filename = $_GET['filename'];   //要下载的文件名
 //下载内容必须的阅读方式
header("Content-Type: application/force-download");
header("Content-Disposition: attachment; filename=".basename($filename)); 
readfile($filename);
?>
