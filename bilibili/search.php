<?php
/*
 * 注：区分大小写
 * by: http://www.daixiaorui.com
 */
error_reporting(0);
if(!empty($_POST['key'])){
    if(intval($_POST['key']) == 0){
        $key = str_replace('uid:','',$_POST['key']);
        $key = str_replace('UID:','',$key);
        if(intval($key) != 0) exit ('<meta http-equiv="refresh" content="0;url=./?uid='.$key.'">');
        $key = str_replace('https://','',$_POST['key']);
        $key = str_replace('http://','',$key);
        preg_match('/\/(\d+)/',$key,$key_trans);
        if(intval($key_trans[1]) == 0) {
            // 处理用户提交的搜索请求
    		$query = $_POST['key'];
    
            $files = glob('../bfanscount/up_info/*.json');
            $cacheFile = '../bfanscount/cache/search.cache';
            
            // 检查是否存在缓存文件，如果不存在或缓存数据少于 JSON 文件数量，则更新缓存
            if (!file_exists($cacheFile) || count(json_decode(file_get_contents($cacheFile), true)) < count($files)) {
                $cachedData = array();
                
                foreach ($files as $file) {
                    $data = json_decode(file_get_contents($file), true);
                    if (isset($data['data']['card']['mid'])) {
                        $cachedData[] = array(
                            'uid' => $data['data']['card']['mid'],
                            'name' => $data['data']['card']['name']
                        );
                    }
                }
                
                file_put_contents($cacheFile, json_encode($cachedData));
            } else {
                // 直接从缓存文件中读取数据
                $cachedData = json_decode(file_get_contents($cacheFile), true);
            }
            
            // 在缓存数据中查找匹配项
            $matches = array();
            foreach ($cachedData as $data) {
                if (stripos($data['name'], $query) !== false) {
                    $matches[] = $data;
                }
            }

    
    		// 如果找到了匹配项，则将其列出
    		//echo "<script>alert('".count($files)."')</script>";
			echo '<div id="result_box" class="mdui-table-fluid mdui-table th"><div class="mdui-panel-item-body mdui-text-color-black-text" style="height:auto!important;margin-top:23px;"><div class="mdui-panel-item-header" style="pointer-events:none;"><div class="mdui-panel-item-title" style="width:100%;"><b style="color:black;font-size:1.0rem;">按昵称搜索：'.$_POST['key'].'</b></div></div>';
			echo '<div class="mdui-typo" style="margin-bottom:15px;"><blockquote>';
    		if (count($matches) > 0) {
    			foreach ($matches as $match) {
    			    $location = "'./?uid=".$match['uid']."'";
    				echo '<li onclick="window.location.replace('.$location.')"><strong>' . htmlspecialchars($match['name']) . '</strong>（UID：' . $match['uid'] . '）</li>';
    			}
    			echo '(单击名称以跳转)</blockquote></div></div></div>';
    		}
    		else echo ('<i class="mdui-icon material-icons">warning</i> 未找到该uid或昵昵称</blockquote></div></div></div>');
        }
        else echo ('<i class="mdui-icon material-icons">warning</i> 未找到该uid或昵称</blockquote></div></div></div>');
    }
    else{
		exit ('<meta http-equiv="refresh" content="0;url=./?uid='.$_POST['key'].'">');	
	}
}
?>