<?php
    session_start();  // 启动会话

    $limit = 60;  // 间隔阈值
    $currentTime = time();  // 当前时间戳
    
    if (isset($_SESSION['lastAccessTime'])) {
        $lastAccessTime = $_SESSION['lastAccessTime'];
    
        if ($currentTime - $lastAccessTime < $limit) {
            // 访问频率超过限制，执行相应的操作，比如拒绝访问或提示用户稍后再试
            exit('<script>alert("访问频率过高，请等待2分钟后再试！");window.open("'.$_SERVER['HTTP_REFERER'].'", "_self");</script>');
        }
    }
    
    // 更新最后访问时间
    $_SESSION['lastAccessTime'] = $currentTime;
    

	header('Content-Type:text/html;charset=utf-8');
	require "imageZip.php";
	require_once './php-sdk/vendor/autoload.php';
	use Upyun\Upyun;
    use Upyun\Config;
	ini_set ("memory_limit","-1");

	//echo '<pre>';
	//$file=$_FILES['img1'];
	// print_r($file);

	// $up='./';
	$img=$_FILES['file'];
	$platform=$_POST['platform'];
	$author=$_POST['author'];
	//print_r($img);
	// die();
	$dir  = '../';
	if ($img['type'] != "image/jpg" && $img['type'] != "image/jpeg" && $img['type'] != "image/png" && $img['type'] != "image/gif" && $img['type'] != "image/svg+xml") {
      //9、输出：<b>失败</b>
      echo '<b>失败</b>--类型不符，仅允许上传jpg，jpeg，png，gif，svg';
      //header("refresh:3;url=/new-upload.html");
      //print('<br>正在返回上传页面<br>三秒后自动跳转...');
      die();
    }
    
    $white =array(".jpeg",".jpg",".png",".gif",".svg"); //白名单文件  //只允许.jpg,.png,.gif通过，Jpg这样的通通不允许
	$filename = trim($_FILES['file']['name']);
	$filename = rtrim($filename,'.');//删除文件名末尾的点
	$processed_filename = strrchr($filename,'.');//获取文件后缀名
	//$processed_filename = str_ireplace('::$DATA', '', $file_ext);//去除字符串::$DATA   Windows特征绕过，linux加不加无所谓
	$processed_filename = trim($processed_filename); //首尾去空  避免空格绕过
	if(in_array($processed_filename,$white))  //判断$文件处理中是否包含$白名单的值  如果是 执行核心代码，否则die()
	{
    
	if (!empty($img['name'])){
		if($img['type']==('image/jpeg'||'image/jpg'||'image/png'||'image/gif'||'image/svg+xml')&&$img['error']==0){
			try{
    			$suffix=explode('.',$img['name']);
    			$count=count($suffix);
    			$uniqid = md5(uniqid(microtime(true),true));
    			//$newname = $uniqid.date('YmdHis',time()).'.'.$suffix[$count-1];
    			if (!empty($platform)||!empty($author)){
    			    $newname = date('YmdHis',time()) .'-' .$platform .'@' .$author .'-' .$uniqid.'.'.$suffix[$count-1];
    			}
    			else{
    			    $newname = date('YmdHis',time()) .'-' .$uniqid.'.'.$suffix[$count-1];
    			}
    			//保存图片
    			//move_uploaded_file($img['tmp_name'],$dir.$newname);
    			//图片压缩---start
    			$source =  $dir.$newname;//原图片名称
    			$dst_img = $dir.substr($newname, 0, strrpos($newname, '.')).'_thumb.'.$suffix[$count-1];//压缩后图片的名称
    
    			if($img["type"]!="image/svg+xml"){
        			$percent = 1;  #原图压缩，不缩放，但体积大大降低
        			$image = (new imgcompress($img['tmp_name'],$percent))->compressImg($dst_img);
        			//图片压缩---end
        			//unlink($source);
        			//删除原图
        			//图片二次压缩---start
        			$percent2 = 1;  #原图压缩，不缩放，但体积大大降低
        			$image = (new imgcompress($dst_img,$percent2))->compressImg($source);
        			//图片二次压缩---end
        			unlink($dst_img);
        			//删除一次压缩
    			} else {
    			    move_uploaded_file($img, $source);
    			}
    			
                $operator = "yujionako";
                $serviceName = "pro-ivan-cloud";
                $password = "kggp4aWK2Bum5NHDL515hiYaiNb9afPL";
                //$upyun = new UpYun($serviceName, $operator, $password);
                $bucketConfig = new Config($serviceName, $operator, $password);
                $client = new Upyun($bucketConfig);
                $path = "/imgbed/upload_pic/";
    			try{
                    // 读文件
                    $file = fopen($source, 'r');         
                    // 上传文件
                    $res = $client->write($path.$newname, $file);
                    // 打印上传结果
                    //print_r($res);
                    unlink($source);
    			}
    			catch(Exception $e) {
    			    unlink($source);
    			    echo '<br><hr><br>';
        			echo '<b>失败</b>--上传失败，请联系管理员<br>code:';
                    echo $e->getCode();
                    echo " ".$e->getMessage();
        			//header("refresh:10;url=/new-upload.html");
                    //exit('<br>正在返回<a href="/new-upload.html">上传页面</a><br>10秒后自动跳转...');
                }
                echo '<br><hr><br>';
    			echo '<b>成功</b>--上传成功至<a href="//us.pro-ivan.com';
                echo $path.$newname;
                echo '" target="_blank">此处</a><br>要获取短链请点击<a href="http://s.pro-ivan.com/?u=https://us.pro-ivan.com'.$path.$newname.'">此处</a>';
    			//header("refresh:10;url=/new-upload.html");
                //print('<br>正在返回<a href="/new-upload.html">上传页面</a><br>10秒后自动跳转...');
		    }
			catch(Exception $e){
			    echo '<br><hr><br>';
    			echo '<b>失败</b>--压缩出错，您上传的可能不是可打开的图片';
    			//header("refresh:10;url=/new-upload.html");
                //print('<br>正在返回<a href="/new-upload.html">上传页面</a><br>10秒后自动跳转...');
			}
		}else{
		    echo '<br><hr><br>';
			echo "<b>失败</b>--类型不符，仅允许上传jpg，jpeg，png，gif')<script type='text/javascript'>alert('location.href=document.referrer;</script>";
			//header("refresh:3;url=/new-upload.html");
            //print('<br>正在返回上传页面<br>三秒后自动跳转...');
			return false;
		}
	}else{
	    echo '<br><hr><br>';
		echo "<b>失败</b>--文件名为空";
		//header("refresh:3;url=/new-upload.html");
        //print('<br>正在返回上传页面<br>三秒后自动跳转...');
	}
    }
    else{
        echo '<br><hr><br>';
    	echo "<b>失败</b>--含有黑名单内内容";
    	//header("refresh:3;url=/new-upload.html");
        //print('<br>正在返回上传页面<br>三秒后自动跳转...');
        die();
    }
	
?>
