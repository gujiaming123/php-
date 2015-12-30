<?php
//收到文本
if ($_FILES["file"]["error"] > 0)
  {
  echo "Error: " . $_FILES["file"]["error"] . "<br />";
  }
else
  {
  echo "上传文件名: " . $_FILES["file"]["name"] . "<br />";
  echo "文件类型: " . $_FILES["file"]["type"] . "<br />";
  echo "文件大小: " . ($_FILES["file"]["size"] / 1024) . " Kb<br /><hr>";
  echo "储存位置: " . $_FILES["file"]["tmp_name"]."<br>";
  }
  
  
  //移动文件 
 $_FILES['file']['name']= time().$_FILES['file']['name'];
  if(is_uploaded_file($_FILES['file']['tmp_name'])){
  move_uploaded_file($_FILES['file']['tmp_name'],$_FILES['file']['name']);
  echo "成功上传";
  }
else{


echo "上传失败";}
//以下为读取内容






$filename=$_FILES['file']['name'];


if(end(explode(".",$filename))=="doc"){
echo "不能打开doc,由于php版本过低，不能加载doc模块，所以操作不正确。";
exit;
//以下为你加载doc模块
// 建立一个指向新COM组件的索引  
$word = new COM("word.application") or die("Can't start Word!");  
 //显示目前正在使用的Word的版本号  
echo "Loading Word, v. {$word->Version}<br>";  
// 把它的可见性设置为0（假），如果要使它在最前端打开，使用1（真）  
// to open the application in the forefront, use 1 (true)  
$word->Visible = 0;  

//打?一个文档  
$word->Documents->OPen($filename);  
//读取文档内容  
$conetent= $word->ActiveDocument->content->Text;  
echo $conetent;  
echo "<br>";  
// 关闭与COM组件之间的连接  
$word->Quit();
}
else{
$handle=fopen($filename,"r");
$conetent=fread($handle,filesize($filename));
echo $conetent."<br>";
}
fclose($handle);
echo "<hr/>";
//以下为取出单词模块

$distinct=true;

/*preg_match_all('/([a-zA-Z]+)/',$conetent,$match);
if($distinct=true)
{
$macth=array_unique($macth);

}

*/

preg_match_all('/([a-zA-Z]+)/',$conetent,$match);

$match[1] = array_unique($match[1]);
   
sort($match[1]);
natcasesort($match[1]) ;//判断大小写
echo "<table align='center' border='1'>";
$i=0;
foreach($match[1] as $key =>$val){
if($i%6=="0"){
echo "<tr>";
}
echo "<th>".$val."</th>";
$i++;
if($i%6=="0"){
echo "</tr>";
}
}
echo "</table>";
echo "<hr/>";

$string=implode("\r\n",$match[1]);
file_put_contents("copy_".$_FILES['file']['name'], $string);
$filename="down.php?filename=copy_".$_FILES['file']['name'];

echo "<a href='$filename' >下载修改过的文本</a>";
?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
<title>返回文本</title>
<div id="YOUDAO_SELECTOR_WRAPPER" style="display:none; margin:0; border:0; padding:0; width:320px; height:240px;"></div>
<script type="text/javascript" src="http://fanyi.youdao.com/openapi.do?keyfrom=goskyda&key=210946422&type=selector&version=1.2&translate=on" charset="utf-8"></script>
</head>



<body>
</body>
</html>
