<?php
include 'header.php';
require("global.php");
$php_file = basename(__FILE__);
$method =isset($_GET['method'])?$_GET['method']:null;

switch($method){
  case 'upload':
		if(isset($_POST['submit'])){
			if ($_FILES["file"]["type"] == "text/plain"){
				if ($_FILES["file"]["error"] > 0)
					$html = "上传文件发生错误：" . $_FILES["file"]["error"];
				else {
					 move_uploaded_file($_FILES["file"]["tmp_name"], "upload/" . $_FILES["file"]["name"]);
					$html = '文件上传成功，请返回首页修改或重新上传！';
				}
			}else {
				$html = '上传文件类型无效，请上传TXT文档！';
			}
			echo $html . '<a href="' . $php_file . '" style="color:#F30; padding-left:10px;">' . "返回上传页面" . '</a>';
		}
		break;
	case 'edit':
		$filename = isset($_GET['filename'])?$_GET['filename']:null;
		echo '<form method="POST" action="'.$php_file.'?method=save" style="width:500px; height:500px; margin:20px;">';
		echo 	'<label >' . $filename . '</label>';
		echo   '<textarea rows="30" cols="80" name="content" style="margin:10px 0;">';
		echo		file_get_contents(ABS_PATH.'/upload/'.$filename);
		echo   '</textarea>';
		
		echo   '<input type="submit" name="submit" value="Submit" />';
		echo '</form>';
		break;
	case 'save':
		$content = isset($_POST['content'])?$_POST['content']:null;
		$filename = isset($_POST['filename'])?$_POST['filename']:null;
		file_put_contents('upload/'.$filename,$content);
		echo "保存成功" . '<a href="' . $php_file . '" style="color:#F30; padding-left:10px;">' . "返回上传页面" . '</a>';
		break;
	default:
		echo '<form action="'.$php_file.'?method=upload" method="POST" enctype="multipart/form-data" style="margin:10px 0;" >';
        echo 	'<label for="file">Filename:</label>';
        echo 	'<input type="file" name="file" id="file" />';
       	echo 	'<input type="submit" name="submit" value="Submit" />';
        echo '</form>';
		
		$directory = "./upload/";
		$text = glob($directory . "*.txt");
		echo '<h3>' . "已上传TXT文档列表".'</h3>' ;
		foreach($text as $txt)
		{
			echo '<p style="padding-bottom:10px; width:400px; display:block; border-bottom:1px dashed #666;">' . substr($txt,9) . '<a href="'.$php_file.'?method=edit&filename='.substr($txt,9).'" style="color:#F30; padding-left:10px;">编辑</a></p>';
		}
		
		break;
}
include 'footer.php';
?>
