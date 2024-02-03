<!doctype html>
<html lang="zh-cmn-Hans">
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" />
		<meta name="renderer" content="webkit" />
		<meta name="force-rendering" content="webkit" />
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
		<link rel="shortcut icon" href="/favicon.ico">
		<link rel="stylesheet" href="/mdui/css/mdui.css" />
		<link rel="stylesheet" href="/new-js/index.css">
		<title>Pro-Ivan数字库-哔哩哔哩粉丝量观测</title>
		<meta name="keywords" content="动漫图片,动漫资讯,动漫,二次元,漫画,动画,游戏,Cosplay,ACG,番剧,视频分享,壁纸,神曲,热门动漫,热门番剧">
		<meta name="description" content="技术宅社团，什么活都整！">
		<style>
		    li:hover {
              cursor: pointer;
              background-color: #eeeeee;
            }

            .level-box {
              width: 3.0em;
              height: 1.2em;
              background-color: #CCCCCC; /* 默认背景颜色 */
              border-radius: 6px;
              display: inline-block;
              text-align: center;
              margin-left: 10px;
            }
            
            .level-text {
              font-size: 16px;
              font-weight: bold;
              color: #FFFFFF; /* 默认文字颜色 */
            }
            
            /* 根据不同的等级设置不同的颜色 */
            .level-box.level-0 {
              background-color: #CCCCCC;
            }
            
            .level-box.level-1 {
              background-color: #CCCCCC;
            }
            
            .level-box.level-2 {
              background-color: #8BD29B;
            }
            
            .level-box.level-3 {
              background-color: #66CCFF;
            }
            
            .level-box.level-4 {
              background-color: #FEBB8B;
            }
            
            .level-box.level-5 {
              background-color: #FF6633;
            }
            
            .level-box.level-6 {
              background-color: #FF0000;
            }
            
            #congratulate {
                border: 5px solid #ffcc00;
                border-radius: 5px;
                text-align: center;
                font-size: 18px;
                font-weight: bold;
                color: #333333;
                display: none;
                max-width: 1200px;
                box-sizing: border-box;
            }
        
        </style>
		<script>
		window.onload = function() {
		    setTimeout(function() {
        		if(document.getElementById('result_box')){
                    document.getElementById('result_box').scrollIntoView({ block: 'end', behavior: 'smooth' });
                }
                else if(document.getElementById('chart_box')){
                    document.getElementById('chart_box').scrollIntoView({ block: 'end', behavior: 'smooth' })
                }
		    }, 400);
		}
        </script>
		<script src="/new-js/echarts.min.js"></script>
		<script>
            function getAverageColor(img) {
              var canvas = document.createElement('canvas');
              var ctx = canvas.getContext('2d');
              var width = canvas.width = img.naturalWidth;
              var height = canvas.height = img.naturalHeight;
            
              ctx.drawImage(img, 0, 0);
            
              var imageData = ctx.getImageData(0, 0, width, height);
              var data = imageData.data;
              var r = 0;
              var g = 0;
              var b = 0;
              var skip = 0;
            
              for (var i = 0, l = data.length; i < l; i += 4) {
                if(data[i]<10&&data[i+1]<10&&data[i+2]<10) {skip++;continue;}
                if(data[i]>=245&&data[i+1]>=245&&data[i+2]>=245) {skip++;continue;}
                r += data[i];
                g += data[i+1];
                b += data[i+2];
              }
            
              r = Math.floor(1.00 * r / ((data.length / 4)-skip));
              g = Math.floor(1.00 * g / ((data.length / 4)-skip));
              b = Math.floor(1.00 * b / ((data.length / 4)-skip));
              

            
              return { r: r<=255?r:255, g: g<=255?g:255, b: b<=255?b:255 };
            }
            
            function load_border() {
                var rgb = getAverageColor(document.getElementById('avatar'));
                var rgbStr = ' rgb(' + rgb.r + ', ' + rgb.g + ', ' + rgb.b + ')';
                document.getElementById('avatar').style.border = '3px solid' + rgbStr;
            }
		</script>
		<script type="text/javascript">
            function AddFavorite(url,title){
             var ua = navigator.userAgent.toLowerCase();
             if(ua.indexOf("msie 8")>-1){
              external.AddToFavoritesBar(url,title,"");//IE8
              }else{
              try {
              window.external.addFavorite(url, title);
              } catch(e) {
              try {
              window.sidebar.addPanel(title, url, "");//firefox
              } catch(e) {
              alert("加入收藏失败，请使用Ctrl+D或手动进行添加");
              }
              }
              }
              return false;
            }
        </script>
		<script>
        	var _hmt = _hmt || [];
        	(function() {
         	 var hm = document.createElement("script");
         	 hm.src = "https://hm.baidu.com/hm.js?90415f833f988b0bccfb250d70f115f6";
         	 var s = document.getElementsByTagName("script")[0]; 
         	 s.parentNode.insertBefore(hm, s);
        	})();
    	</script>
	</head>
	<body class="mdui-drawer-body-left mdui-theme-primary-light-blue mdui-theme-accent-light-blue">
		<div class="mdui-drawer" id="left-drawer" style="z-index:3000;">
			<img src="/Ivan.svg" style="max-width: 100%; max-height: 100%;">
			<ul class="mdui-list">
				<li class="mdui-list-item mdui-ripple" onclick="home()">
					<i class="mdui-list-item-icon mdui-icon material-icons">home</i>
					<div class="mdui-list-item-content">主页</div>
				</li>
				<li class="mdui-list-item mdui-ripple" mdui-dialog="{target: '#announcement'}">
					<i class="mdui-list-item-icon mdui-icon material-icons">message</i>
					<div class="mdui-list-item-content">公告</div>
				</li>
				<li class="mdui-list-item mdui-ripple" mdui-dialog="{target: '#support'}">
					<i class="mdui-list-item-icon mdui-icon material-icons">account_balance_wallet</i>
					<div class="mdui-list-item-content">支持我们</div>
				</li>
				<li class="mdui-list-item mdui-ripple" onclick="imgs()">
					<i class="mdui-list-item-icon mdui-icon material-icons">image</i>
					<div class="mdui-list-item-content">图库</div>
				</li>
				<li class="mdui-list-item mdui-ripple" onclick="comic()">
					<i class="mdui-list-item-icon mdui-icon material-icons">book</i>
					<div class="mdui-list-item-content">漫画</div>
				</li>
				<li class="mdui-list-item mdui-ripple" onclick="img_bed()">
					<i class="mdui-list-item-icon mdui-icon material-icons">cloud_queue</i>
					<div class="mdui-list-item-content">图床</div>
				</li>
				<li class="mdui-list-item mdui-ripple" onclick="download()">
					<i class="mdui-list-item-icon mdui-icon material-icons">file_download</i>
					<div class="mdui-list-item-content">下载站</div>
				</li>
				<li class="mdui-list-item mdui-ripple" onclick="little_game()">
					<i class="mdui-list-item-icon mdui-icon material-icons">extension</i>
					<div class="mdui-list-item-content">小游戏</div>
				</li>
				<li class="mdui-list-item mdui-ripple" onclick="alert('you are here')">
					<i class="mdui-list-item-icon mdui-icon material-icons">people</i>
					<div class="mdui-list-item-content">Bilibili粉丝量观测</div>
				</li>
				<li class="mdui-list-item mdui-ripple" onclick="api()">
					<i class="mdui-list-item-icon mdui-icon material-icons">leak_add</i>
					<div class="mdui-list-item-content">Api接口</div>
				</li>
				<li class="mdui-list-item mdui-ripple" onclick="about()">
					<i class="mdui-list-item-icon mdui-icon material-icons">face</i>
					<div class="mdui-list-item-content">关于我们</div>
				</li>
			</ul>
		</div>
		<div class="mdui-dialog" id="announcement">
			<div class="mdui-dialog-title">公告</div>
			<div class="mdui-dialog-content">
				<div id="GG"></div>
			</div>
			<div class="mdui-dialog-actions">
				<button class="mdui-btn mdui-ripple mdui-text-color-theme mdui-text-color-white" mdui-dialog-close >关闭</button>
			</div>
		</div>
		<div class="mdui-dialog" id="support">
			<div class="mdui-dialog-title">支持我们</div>
			<div class="mdui-dialog-content">
                如果您有能力，还请多多支持我们！
				<br>
				<img src="/sponsor/weixin.webp" class="support-img" width="48%" />
				<img src="/sponsor/alipay.webp" class="support-img" width="48%" style="margin-left:2%;"/>
			</div>
			<div class="mdui-dialog-actions">
				<button class="mdui-btn mdui-ripple mdui-text-color-theme mdui-text-color-white" mdui-dialog-close >关闭</button>
			</div>
		</div>
		</div>
		<div class="mdui-appbar">
			<div class="mdui-toolbar mdui-color-theme" style="position:fixed;z-index:1000;margin-top:-75px;" mdui-headroom>
				<a href="javascript:;" mdui-drawer="{target: '#left-drawer'}" class="mdui-btn mdui-btn-icon" onclick="setTimeout(function() {if(typeof(myChart)!='undefined')myChart.resize();}, 301)">
					<i class="mdui-icon material-icons">menu</i>
				</a>
				<a id="title" href="/new.html" class="mdui-typo-headline">Pro-Ivan数字库-哔哩哔哩粉丝量观测</a>
				<div class="mdui-toolbar-spacer"></div>
				<a href="javascript:;" class="mdui-btn mdui-btn-icon" onclick="AddFavorite('http://pro-ivan.cn','Pro-Ivan')">
					<i class="mdui-icon material-icons" mdui-tooltip="{content: '收藏本页'}">star</i>
				</a>
			</div>
		</div>
		<div id="body" class="mdui-container-fluid">
		    <div class="mdui-panel" style="margin-top:70px">
		        <div class="mdui-table-fluid mdui-table th" style="width: 100%;margin: 0 auto;">
		            <div>
    		            <img id="avatar" class="mdui-img-circle" src="default.png" width=100px height=100px  referrerpolicy="no-referrer" crossorigin="anonymous" style="margin:10px 15px;float:left;border:3px solid grey;box-sizing: border-box;" onload="load_border();" onerror="this.src='default.png'">
    		            <a id="go_home" href="//space.bilibili.com" class="mdui-btn mdui-btn-icon" style="float:right;margin:42px;" target="_blank">
        					<i class="mdui-icon material-icons" mdui-tooltip="{content: 'Up主页'}">home</i>
        				</a>
    		            <div style="float:left;margin-left:5px; margin-top: 10px;">
    		                <h1 id="name" style="margin-left:10px; display: inline-block;">未输入uid</h1>
    		                <div id="level-box" class="level-box">
                              <span id="level-text" class="level-text">Lv0</span>
                            </div>
    		                <div id="uid-str" style="margin-left:10px; display: inline-block; color: gray;" mdui-tooltip="{content: '单击以复制uid'}" onclick="navigator.clipboard.writeText(this.textContent.replace('UID: ', ''));alert('已复制uid到剪切板');">UID: 0</div>
                            <div id="official_verify" class="mdui-typo-body-3-opacity" style="margin-left:10px; margin-right:10px;"><i class="mdui-list-item-icon mdui-icon material-icons">error</i>&nbsp;输入id才看得到观测记录哦~</div>
    		            </div>
		            </div>
	                <div class="mdui-table-fluid mdui-table mdui-typo" style="margin-bottom:15px; margin-left: 15px; max-width: 95%">
                      <blockquote>
                        <p id="sign" class="mdui-typo-body-2-opacity"></p>
                      </blockquote>
                    </div>
		        </div>
		        <br>
		        <div id="congratulate" class="mdui-table-fluid mdui-table" style="width: 100%; margin: 0 auto; text-align: center;">
		            
		        </div>
		        
		        <br>
		        <div id="base_info"></div><br>
		        <div id="chart_box" class="mdui-table-fluid mdui-table th" style="width: 100%;height: auto;margin: 0 auto;">
		            <div id="chart" style="height:95%;width:99%;margin-top:15px;"><h1><center>无法获取到粉丝数据</center></h1></div>
		        </div>
		        <div id="notes" class="mdui-table-fluid mdui-table th" style="width: 100%; text-align: center;box-sizing: border-box;margin: 0 auto;"></div><br>
		        
		        <div id="search_box" class="mdui-table-fluid mdui-table th" style="width: 100%;height: auto;margin: 0 auto;">
		            <div id="" style="height:95%;width:99%;margin-top:15px;">
		                <div class="mdui-panel-item-body mdui-text-color-white-text" style="height:auto!important;">
                          <form class="mdui-textfield mdui-textfield-floating-label" action="" method="post" style="margin-right:23px;">
                              <div class="mdui-panel-item-header" style="pointer-events:none;">
        						<div class="mdui-panel-item-title"><b style="color:black;font-size:1.5rem;">搜索器</b></div>
        						<div class="mdui-panel-item-summary"></div>
        					  </div>
                              <i class="mdui-icon material-icons">account_circle</i>
                              <label class="mdui-textfield-label">请输入目标uid/链接/昵称</label>
                              <input class="mdui-textfield-input" type="text" name="key" id="key"/>
                              <div class="mdui-textfield-helper">昵称可以是模糊搜索嗷~</div>
                              <input id="search" class="mdui-btn mdui-color-theme mdui-text-color-white-text" type="submit" name="sub" value=" 查 找 " style="display:none;" />
                          </form>
                          <button class="mdui-btn mdui-color-theme mdui-text-color-white-text" onclick="document.getElementById('search').click();" style="margin-right:24px;float:right;"> 查 找 </button>
                          <button class="mdui-btn mdui-color-theme mdui-text-color-white-text" onclick="navigator.clipboard.readText().then(function(text) {document.getElementById('key').value = text;});" style="margin-right:24px;float:right;"> 粘 贴 </button><br>
    		        </div>
		            </div>
		        </div>
		        
		        
	            <?php
                /*
                 * 注：区分大小写
                 * by: http://www.daixiaorui.com
                 */
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
                    
                    		// 查找包含博主名称的 JSON 文件
                    		$files = glob('../bfanscount/up_info/*.json');
                    		$matches = array();
                    		foreach ($files as $file) {
                    			$data = json_decode(file_get_contents($file), true);
                    			if (isset($data['data']['card']['name']) && stripos($data['data']['card']['name'], $query) !== false) {
                    				$matches[] = array(
                    					'uid' => $data['data']['card']['mid'],
                    					'name' => $data['data']['card']['name']
                    				);
                    			}
                    		}
                    
                    		// 如果找到了匹配项，则将其列出
                    		//echo "<script>alert('".count($files)."')</script>";
                    		if (count($matches) > 0) {
                    			echo '<div id="result_box" class="mdui-table-fluid mdui-table th"><div class="mdui-panel-item-body mdui-text-color-black-text" style="height:auto!important;margin-top:23px;"><div class="mdui-panel-item-header" style="pointer-events:none;"><div class="mdui-panel-item-title" style="width:100%;"><b style="color:black;font-size:1.0rem;">按昵称搜索：'.$_POST['key'].'</b></div></div>';
                    			echo '<div class="mdui-typo" style="margin-bottom:15px;"><blockquote>';
                    			foreach ($matches as $match) {
                    			    $location = "'./?uid=".$match['uid']."'";
                    				echo '<li onclick="window.location.replace('.$location.')"><strong>' . htmlspecialchars($match['name']) . '</strong>（UID：' . $match['uid'] . '）</li>';
                    			}
                    			echo '(单击名称以跳转)</blockquote></div></div></div>';
                    		}
                    		else echo ('<script>alert("未找到该uid或昵称")</script>');
                        }
                        else echo ('<script>alert("未找到该uid或昵称")</script>');
                    }
                    else{
                		exit ('<meta http-equiv="refresh" content="0;url=./?uid='.$_POST['key'].'">');	
                	}
                }
                ?>
		        
		        <div id="add_box" class="mdui-table-fluid mdui-table th" style="width: 100%;height: auto;margin: 0 auto;">
                    <div id="chart" style="height:95%;width:99%;margin-top:15px;">
                        <div class="mdui-panel-item-body mdui-text-color-white-text" style="height:auto!important;">
                    		<form class="mdui-textfield mdui-textfield-floating-label" action="./add.php" method="post" style="margin-right:23px;">
                              <div class="mdui-panel-item-header" style="pointer-events:none;">
                            	<div class="mdui-panel-item-title"><b style="color:black;font-size:1.5rem;">添加器(试运行)</b></div>
                            	<div class="mdui-panel-item-summary"></div>
                              </div>
                              <div style="color:gray;margin-left:25px;">已纳入观测up主数量：<div id="ob_count" style="display:inline-block;">N/A</div></div>
                              <i class="mdui-icon material-icons">add_circle_outline</i>
                              <label class="mdui-textfield-label">请输入目标uid/链接</label>
                              <input class="mdui-textfield-input" type="text" name="new_uid" id="new_uid"/>
                              <div class="mdui-textfield-helper">暂不支持按昵称添加嗷~</div>
                              <input id="add" class="mdui-btn mdui-color-theme mdui-text-color-white-text" type="submit" name="sub" value=" 添 加 " style="display:none;" />
                            </form>
                            <button class="mdui-btn mdui-color-theme mdui-text-color-white-text" onclick="document.getElementById('add').click()" style="margin-right:24px;float:right;"> 添 加 </button>
                          <button class="mdui-btn mdui-color-theme mdui-text-color-white-text" onclick="navigator.clipboard.readText().then(function(text) {document.getElementById('new_uid').value = text;});" style="margin-right:24px;float:right;"> 粘 贴 </button><br>
                        </div>
                    </div>
                </div>
		    </div>
		</div>
		
    	    


		<footer><div id="footer"></div></footer>
		</body>
	<script src="/mdui/js/mdui.min.js"></script>
	<script src="/new-js/index.js"></script>
	
		<script type="text/javascript">
            // 创建XMLHttpRequest对象
            var xhr = new XMLHttpRequest();

            // 设置请求方式和URL到.config
            xhr.open('GET', '../bfanscount/.config?' + Math.random().toString(36).substring(7), true);

            // 设置响应类型为json
            xhr.responseType = 'json';

            // 发送请求
            xhr.send();

            // 监听请求的加载事件
            xhr.onload = function() {
              // 检查请求的状态
              if (xhr.status === 200) {
                // 获取JSON数据
                var jsonData = xhr.response;
    
                // 获取JSON数组的长度
                var count = jsonData.length;
    
                // 将长度填充到指定的div元素中
                document.getElementById('ob_count').innerText = count;
              }
            };
            

            var uid = parseInt(new URLSearchParams(window.location.search).get('uid'));
            var myChart;
            if (isNaN(uid)) {
              uid = -1;
              console.error('Invalid uid parameter');
            }
            else{
            var data =[];
            var time = [];
            var fans = [];
            var request = new XMLHttpRequest();
            request.open('GET', '../bfanscount/json/' + uid + '.json?' + Math.random().toString(36).substring(7), true);
            request.responseType = 'json';
            request.onload = function() {
              if (request.readyState === 4 && request.status === 200) {
                data = request.response;
                for (var i = 0; i < data.length; i++) {
                  time.push(data[i].time);
                  fans.push(data[i].fans);
                }
                console.log('time:', time);
                console.log('fans:', fans);
              }
                if(uid!==-1&&uid!=='')document.getElementById('name').innerHTML = "加载中";
                var baseinfo = {};
                var xhr = new XMLHttpRequest();
                xhr.open('GET', '../bfanscount/up_info/' + uid + '.json');
                xhr.responseType = 'json';
                xhr.onload = function() {
                  if (xhr.readyState === 4 && xhr.status === 200) {
                    baseinfo = xhr.response;
                    
                    console.log(baseinfo);
                    
                    build(baseinfo, fans, time);
                  } else if(!document.getElementById('result_box')) {
                    console.log('Request failed.  Returned status of ' + xhr.status);
                    alert("未记录的uid：" + uid);
                    document.getElementById('name').innerHTML = "未记录该uid：" + uid;
                  }
                };
                xhr.send();
            };
            request.send();
            

            
            
            function build(baseinfo, fans, time){ //建立chart 
            setTimeout(function(){ // 1000ms延时以等待json加载
                var name = JSON.stringify(baseinfo.data.card.name).replaceAll('\"','');
                var avatar = JSON.stringify(baseinfo.data.card.face).replaceAll('\"','');
                var sign = ((JSON.stringify(baseinfo.data.card.sign).replaceAll('\"','')).replaceAll(/\\r|\\n/ig,"<br>")).replaceAll(/`/g, '\\`');
                var official_verify = JSON.stringify(baseinfo.data.card.official_verify.desc).replaceAll('\"','');
                var verify_type = baseinfo.data.card.official_verify.type; //-1 无 0 个人 1 企业
                var usr_level = baseinfo.data.card.level_info.current_level;
                document.getElementById('avatar').src = avatar+"@120w_120h_1c";
                document.getElementById('name').innerHTML = name;
                document.title = 'Pro-Ivan数字库-哔哩哔哩粉丝量观测-' + name;
                document.getElementById('sign').innerHTML = sign !== '' ? sign : '这个人很神秘，什么都没有写';
                document.getElementById('official_verify').innerHTML = (verify_type == -1 ? '<div style="opacity:0.4;"><i class="mdui-icon material-icons">do_not_disturb</i>&nbsp;无认证</div>' : verify_type==0 ? '<img id="verify_type" class="mdui-img-circle" src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABYAAAAWCAYAAADEtGw7AAAAAXNSR0IArs4c6QAAAmtJREFUOBG1lc1rFEEQxd/sxt0xmoSAH7gRBUHRDQQTF3Ly7kn9ExT1KngKntRjToJnvYpHNyc95xSIBoQEFQkE/CZBNxGzq8T1va6enc3YkxCIBTU93V31m+qu7poIOdJutwc5dclrlW3Fm35ku0CtS6Mo+ubHt24IjKm3qd+p24lsZBtnqVH3AA2G2H9Krbnxxgyw/AxYfQH8+mqmpUNA/zngwAVgYNzGgFm+XGb0H5KBDthDScIQ1peAxXsGTCxDrT5w4g6w97hmBR1P4A7slzLNiRpWXwKvbwIbazLeXop9wOkHXMWYbBX5ecKbBe95i23NRboVNGZkfaPexTcKQD5apW2hWCgw2kG2E+q45edFGh8Dhh8RfNaZbnrIR1tnMiGmItaRGoASpSSFpMycVh8CpYPAj1chC/MVQywyE7BlP+RSOmKRlg8D7Q2CdYRzRCfIxIF1+MPRlggbZqRlwiU/3wF/1u099ExXXO3hvN2o5JwmDnu4bC0/PpqM8J3JG+tEBaw8B5bup/MpoyJwWCpXgGIvL8ayzff0s88LVvTRN3lsPz3O+LrT68YiZvAN305h7iLQdEcmY+y7I0+AfWes0/oMzF8FWiobXaIVjU5p4K2SZ9nQLcqTAiPtPWmzrS+EXvsXqtmUMS9w3Xno7ueJIo24a9qWhRuEvg9bpoypBNxwBSX94mbH/SPA7xWD5m2XfK0oNehcL/h6OulIKii6+1lZm+Pyr/PaLmZnrC8f+ZpMiunS+D+KUOd8EK5aPEPdYdm8y7LJOhIqmxqVePiuFHojdj21LdTd/TV18RW9yqkqn3THP9O/Z5k7Zas4v+AAAAAASUVORK5CYII=" style="margin-top: -3px; vertical-align: middle; margin-right: 5px; float:left; height: 1.5em">up主个人认证：':'<img id="verify_type" class="mdui-img-circle" src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABYAAAAWCAYAAADEtGw7AAAAAXNSR0IArs4c6QAAAnFJREFUOBG1VU1PFEEQfbOIrAqSBULIcjFCJGww0WQTT/oXMPF/aDwBJp48kL1yNcG/4PIT4LQJBw+KGhMTNLtBAeXDD9Dg+l53NbTDDMYEX1LT09VVb6q7q2oS5KDdbpe4NGlS4Vg20xbHFUpdkiTJZ9OfPJCwSJmhbFH+BtnItphmTWIFDYY5f0qpSv9sG1jcBJ7vAJs/pAH6zwITF4Fb/cC1Xq/jc5lym9E3g+aQ2EgbXBhufgfm3pJwN5hljxM9wN3LdDjn1kV6I5A7YtvKEheqiu7Ra+DLQTZZWtvdATwc87vgmiK/SfK9ghne51hVpCeRlnmSFUYZQwHIR76EjlBcKDDaEscpTbT9vEhFWmNupInlJx/5GqbEqYiVUr26qLwzHeoCZseBPl7cq5xzl684xEWZDMTu9p069Rgk2SwjHSD5QRt48zVlEE2VQQZHrOR3KRW0YRww0kGSCqvfgP1f/j3rqYs3VM7wxVVUyNOw0tfpIx2KUl9p9eR6sACWGOH8u6N5xFEWcSbu8HNFHtQnK4weWnZxHqL/sAcsrP3pelgUVIu4RbmiimrSOODxKiAJmLsKjFzws/V9YPolsGEfDTa6XENLl6eG4srUlMcGRXrpvFeLbJoeH0mehkrd8ELEdU1U+3kYZaQd3KeOZYakaxmk8o04FgLxthqKaj8LY93A1k/gAbffio4rtpWvNSVlc71g/bQmIzUU1X4aK0x+bf+9L9v0svORr6EmTneR/6MJOWJ9ieTqxQ3KP7XNeyMsBJ/rx9umiAUjP5VG7xmjp46Fcrq/pohf0Zc4V+eTqJ+UKYIKSrmvNM39mf4GT1A5pJajxnQAAAAASUVORK5CYII=" style="margin-top: -3px; vertical-align: middle; margin-right: 5px; float:left; height: 1.5em">企业/机构认证：') + official_verify;
                if (uid==11022578) {
                    document.getElementById('official_verify').innerHTML = '<img src="/favicon.ico" style="margin-top: -3px; vertical-align: middle; margin-right: 5px; float:left; height: 1.5em"> Pro-Ivan站长与社团负责人';
                }
                document.getElementById('level-text').innerHTML = 'LV' + usr_level;
                document.getElementById('level-box').classList.add(`level-${usr_level}`);
                document.getElementById('uid-str').innerHTML = 'UID: ' + uid;
                document.getElementById('go_home').href = "https://space.bilibili.com/"+uid;
                document.getElementById('chart_box').style = "width: 100%;height: 450px;margin: 0 auto;";

      
            
            
            

                var tempFans = [];
                for(var i=0;i<time.length;i++){
                    if(fans[i]!=-1)
                        tempFans.push([time[i],fans[i]]);
                }
                fans = tempFans;

                
                mintime = `"${JSON.stringify(time[0])}"`.substring(2,13)+"00:00:00";
                maxtime = `"${JSON.stringify(time[time.length-1])}"`.substring(2,13)+"23:59:59";
                
                function fans_dif(data, time){ // 计算粉丝单位时间内增量
                    let result = [];
                    
                    // Loop through each record
                    for (let i = 0; i < data.length; i++) {
                      let record = data[i];
                    
                      // Find the record from one day ago
                      let dayAgo = null;
                      for (let j = i - time<0?0:i - time; j >= 0; j--) {
                        let timeDiff = Math.abs(new Date(record[0].replace(' ', 'T')) - new Date(data[j][0].replace(' ', 'T'))); //iPadOS似乎不支持Date(x-x-x x:x:x)，但支持(x-x-xTx:x:x)
                        if (timeDiff >= (time-1)*24*60*60*1000 + 18*60*60*1000 && timeDiff <= (time-1)*24*60*60*1000 + 30*60*60*1000) {
                          dayAgo = data[j];
                          break;
                        }
                      }
                    
                      // Calculate the fan difference
                      let fansDiff = null;
                      if (dayAgo !== null) {
                        fansDiff = record[1] - dayAgo[1];
                      }
                     
                     
                     
                      // Add the result to the output array
                      if (time != 1 && fansDiff != null) {fansDiff = (fansDiff/time).toFixed(2);}
                      if(result.length === 0 || fansDiff != null) {
                          result.push(
                             [record[0], fansDiff]
                          );
                      }
                    }
                    
                    console.log(result);
                    return result;
                }
                
                var rate1 = fans_dif(fans, 1);
                var rate7 = fans_dif(fans, 7);
                var rate14 = fans_dif(fans, 14);
                var rate30 = fans_dif(fans, 30);
                
                function fans_node(fans, delta_time) { //获取粉丝里程碑数组
                    // 假设 fans 和 time 数组已经定义并填充了相应的值
                    // 设置阈值和当前时间
                    // fans 粉丝-时间数组 threshold 超过该值的阈值 delta_time 展示的时间差
                    var currentDate = new Date(); // 当前时间
                    var results = []; // 结果
                    let result = []; // 每个节点可能的结果
                    var thresholds = [];

                    // 0-10000中可被1000整除的数
                    for (var i = 1000; i < 10000; i += 1000) {
                      thresholds.push(i);
                    }
                    
                    // 10000-100000中可被10000整除的数
                    for (var i = 10000; i < 100000; i += 10000) {
                      thresholds.push(i);
                    }
                    
                    // 100000-1000000中可被100000整除的数
                    for (var i = 100000; i < 1000000; i += 100000) {
                      thresholds.push(i);
                    }
                    
                    // 100000-1000000中可被500000整除的数
                    for (var i = 1000000; i < 10000000; i += 500000) {
                      thresholds.push(i);
                    }
                    
                    // 10000000以上可被1000000整除的数
                    for (var i = 10000000; i <= 100000000; i += 1000000) {
                      thresholds.push(i);
                    }
                    
                    function predictiveTimeNode(coordinates, newValue) { //计算粉丝里程碑达成预估时间
                      var time1 = new Date(coordinates[0][0].replace(' ', 'T'));
                      var value1 = coordinates[0][1];
                    
                      var time2 = new Date(coordinates[1][0].replace(' ', 'T'));
                      var value2 = coordinates[1][1];
                    
                      // 计算时间差和数值差
                      var timeDiff = time2.getTime() - time1.getTime();
                      var valueDiff = value2 - value1;
                    
                      // 计算时间比例
                      var valueRatio = (newValue - value1) / valueDiff;
                    
                      // 计算新时间
                      var newTime = new Date(time1.getTime() + timeDiff * valueRatio);
                    
                      return newTime;
                    }
                    
                    // 遍历 fans 数组
                    for (var j = 0; j < fans.length; j++) {
                        result = [];
                        // 遍历thresholds
                        for(var i = 0; i < thresholds.length; i++) {
                          // 解析时间节点字符串为日期对象
                          var arrayNode = new Date(fans[j][0].replace(' ', 'T'));
                        
                          // 检查 fans 值是否超过阈值
                          if (j-1<0) var previous=j;
                          else var previous=j-1;
                          if (fans[j][1] >= thresholds[i] && fans[previous][1] < thresholds[i]) {
                            var timeNode = predictiveTimeNode([fans[previous], fans[j]], thresholds[i]);
                            // 计算时间节点与当前时间的差异（以毫秒为单位）
                            var timeDiff = currentDate - timeNode;
                        
                            // 将时间差转换为天数
                            var daysDiff = timeDiff / (1000 * 60 * 60 * 24);
                        
                            // 判断时间差是否小于7天
                            if (daysDiff < delta_time) { // 符合节点则记录：是否在通报时间内/该通报的粉丝节点/该通报的粉丝与时间信息
                              result = [true, thresholds[i], timeNode.toLocaleString().replace('T', ' ').replaceAll('/','-').split('.')[0]];
                            }
                            else {
                              result = [false, thresholds[i], timeNode.toLocaleString().replace('T', ' ').replaceAll('/','-').split('.')[0]];
                            }
                          }
                        }
                        if (JSON.stringify(result)=='[]') {console.log('fans_node calculate skip')}
                        else {results.push(result);}
                    }
                    return results;
                }
                
                var fans_nodes = fans_node(fans, 7);
                if (fans_nodes.length != 0) {
                    if (fans_nodes[fans_nodes.length-1][0]==true){
                        document.getElementById('congratulate').innerHTML = `<h3 id="congratulate_text" style="margin-left:10px; margin-right: 10px; display: inline-block;">恭喜 ${name} 于${fans_nodes[fans_nodes.length-1][2].split(" ")[0]}**达成 ${fans_nodes[fans_nodes.length-1][1]} 粉丝成就！</h3>`;
                        document.getElementById('congratulate').style.display = 'block'; 
                    }
                }
                var fans_nodes4chart = [];
                for (var i = 0; i < fans_nodes.length; i++) {
                    fans_nodes4chart.push([fans_nodes[i][2], fans_nodes[i][1]]);
                }
                
                
                function fansk(data, time){ // 一段时间内粉丝量均值
                    let result = [];
                    
                    // Loop through each record
                    for (let i = 0; i < data.length; i++) {
                      let record = data[i];
                    
                      // Find the record from one day ago
                      let dayAgo = [];
                      for (let j = i-time-2<0?0:i-time-2; j < data.length; j++) {
                        let timeDiff = Math.abs(new Date(record[0].replace(' ', 'T')) - new Date(data[j][0].replace(' ', 'T'))); //iPadOS似乎不支持Date(x-x-x x:x:x)，但支持(x-x-xTx:x:x)
                        if (timeDiff <= (0.5*(time*24*60*60*1000) + 4*60*60*1000)) {
                            dayAgo.push(data[j][1]);
                        }
                        else if(dayAgo.length!==0) {
                            break
                        }
                      }
                      
                    
                      // Calculate the fan difference
                      let fansDiff = null;
                      if (JSON.stringify(dayAgo) !== '[]') {
                        var sum = 0;
                        for (var k = 0; k < dayAgo.length; k++) {
                          sum += dayAgo[k];
                        }
                        fansDiff = sum / dayAgo.length;
                      }
                     
                     
                     
                      // Add the result to the output array
                      if (time != 1 && fansDiff != null) {fansDiff = fansDiff.toFixed(2);}
                      if (i < time*2) {fansDiff = null;}
                      if(fansDiff != null) {
                          result.push(
                             [record[0], fansDiff]
                          );
                      }
                    }
                    

                    
                    console.log(result);
                    return result;
                }
                
                var fansk7 = fansk(fans, 7);
                var fansk14 = fansk(fans, 14);
                var fansk30 = fansk(fans, 30);
                

                
                function formatNumber(num) { //防数字过长
                  if (num == null) {
                      return '-'
                  }
                  if (num >= 100000 || num <= -100000) {
                    if (num >= 10000000 || num <= -10000000) {
                        return (num / 10000).toFixed(0) + '<small><b>万</b></small>';
                    }
                    else{
                        return (num / 10000).toFixed(1) + '<small><b>万</b></small>';
                    }
                  } else {
                    return num;
                  }
                }
    
    
                document.getElementById('base_info').innerHTML = `<div class="mdui-row mdui-col-12 mdui-center mdui-valign" style="max-width:1200px;"><div class="mdui-table-fluid mdui-table mdui-col-xs-4" style="height:110px;margin-bottom:15px;"><div style="float:left;margin-left:5px;"><p id="" class="mdui-typo-body-2-opacity">粉丝总数量</p></div><div class="mdui-typo" style="margin-bottom:15px;float:right;bottom:0px;right:5px;position:absolute;"><h2 id="" style="margin-right:5px;"><b>${formatNumber(fans[fans.length-1][1])}</b></h2></div></div><div class="mdui-table-fluid mdui-table mdui-col-xs-4" style="height:110px;margin-left:15px;margin-bottom:15px;"><div style="float:left;margin-left:5px;"><p id="" class="mdui-typo-body-2-opacity">1日增长量</p></div><div class="mdui-typo" style="margin-bottom:15px;float:right;bottom:0px;right:5px;position:absolute;"><h2 id="" style="margin-right:5px;"><b>${formatNumber((rate1[rate1.length-1][1]))}</b></h2></div></div><div class="mdui-table-fluid mdui-table mdui-col-xs-4" style="height:110px;margin-left:15px;margin-bottom:15px;"><div style="float:left;margin-left:5px;"><p id="" class="mdui-typo-body-2-opacity">7日增长量</p></div><div class="mdui-typo" style="margin-bottom:15px;float:right;bottom:0px;right:5px;position:absolute;"><h2 id="" style="margin-right:5px;"><b>${rate7[rate7.length-1][1] == null ? '-' : formatNumber((rate7[rate7.length-1][1]*7).toFixed(0))}</b></h2></div></div></div>`;
                
                document.getElementById('notes').innerHTML = `* X日均粉丝量计算方法为对应时间点两侧共计X日内所有数据的均值<br>** 为估计值，估计方法是参考里程碑节点两端数据点连成的线性方程<br>本表最后更新时间：${fans[fans.length-1][0]}`;
                document.getElementById('notes').style.padding = '12px';
                if(document.getElementById('body').offsetWidth<=700){
                    document.getElementById('notes').style.fontSize  = '10px';
                }
                

                
                var chartDom = document.getElementById('chart');
                var option;
                myChart = this.echarts.init(chartDom);
                option = {
                  animationDuration: 2000,
                  aria: {
                    show: true,
                    description: `这是一份关于${name}的粉丝量变化的图表，该表以时间为横轴，以粉丝量计数与粉丝变化量为纵轴，涵盖粉丝量、周均粉丝量、两周均粉丝量、月均粉丝量、1日粉丝变化量、7日内粉丝日均变化量、14日内粉丝日均变化量、30日内粉丝日均变化量以及视图内粉丝数最高最低点、up主粉丝里程碑共计11个计量指标。截止到时间：${fans[fans.length-1][0]}，${name}已收获粉丝${fans[fans.length-1][1]}人，近一日粉丝变化量为${(rate1[rate1.length-1][1])}，近七日粉丝变化量为${rate7[rate7.length-1][1] == null ? '-' : (rate7[rate7.length-1][1]*7).toFixed(0)}（折合日均变化量${rate7[rate7.length-1][1] == null ? '-' : (rate7[rate7.length-1][1]*1).toFixed(0)}）。` + (fans_nodes.length===0?`在目前的记录中，还未找到${name}达到过的粉丝数里程碑。`:`此外，${name}还在日期：${(fans_nodes[fans_nodes.length-1][2]).split(" ")[0]}达成了${fans_nodes[fans_nodes.length-1][1]}粉丝的里程碑。}`)
                  },
                  title: {
                    left: 'center',
                    text: name+" 粉丝量变动"
                  },
                  tooltip: {
                    trigger: 'axis'
                  },
                  dataZoom: [
                    {
                      show: true,
                      realtime: true,
                      type: 'slider',
                      start: fans.length<=60?0:(1-(60/fans.length))*100,
                      end: 100,
                      xAxisIndex: [0, 1]
                    }
                  ],
                  grid: {
                    bottom: '15%',
                    containLabel: true
                  },
                  legend: [
                  {
                    data: ['粉丝数', '粉丝数周均*', '粉丝数二周均*', '粉丝数月均*'],
                    type: "scroll",
                    height: "auto",
                    top: 20
                  },
                  {
                    data: ['1日增长', '7日增长(日均)', '14日增长(日均)', '30日增长(日均)'],
                    type: "scroll",
                    height: "auto",
                    top: 40,
                    itemWidth: 10
                  },
                  {
                    data: ['UP主粉丝量里程碑**', '视图内最高粉丝记录', '视图内最低粉丝记录'],
                    itemHeight: 16,
                    itemWidth: 16,
                    type: "scroll",
                    height: "auto",
                    bottom: 40
                  }],
                  xAxis: {
                    type: 'time',
                    min:mintime,
                    max:maxtime
                  },
                  yAxis: [
                    {
                        name:'粉丝计数',
                        type: 'value',
                        nameLocation: 'middle',
                        alignTicks: true,
                        scale: true,
                        axisLabel: {
                          inside: true
                        }
                    },
                    {
                        name:'粉丝变化量',
                        type: 'value',
                        nameLocation: 'middle',
                        alignTicks: true,
                        scale: false,
                        axisLabel: {
                          inside: true
                        }
                    }
                  ],
                  series: [
                  {
                    name: '粉丝数',
                    type: 'line',
                    zlevel: 9,
                    //smooth: true,
                    data: fans,
                    showSymbol: false,
                    yAxisIndex: 0,
                    emphasis: {
                        focus: 'series',
                        blurScope: 'coordinateSystem'
                    }
                  },
                  {
                    name: '粉丝数周均*',
                    type: 'line',
                    zlevel: 8,
                    //smooth: true,
                    data: fansk7,
                    showSymbol: false,
                    yAxisIndex: 0,
                    emphasis: {
                        focus: 'series',
                        blurScope: 'coordinateSystem'
                    }
                  },
                  {
                    name: '粉丝数二周均*',
                    type: 'line',
                    zlevel: 7,
                    //smooth: true,
                    data: fansk14,
                    showSymbol: false,
                    yAxisIndex: 0,
                    emphasis: {
                        focus: 'series',
                        blurScope: 'coordinateSystem'
                    }
                  },
                  {
                    name: '粉丝数月均*',
                    type: 'line',
                    zlevel: 6,
                    //smooth: true,
                    data: fansk30,
                    showSymbol: false,
                    yAxisIndex: 0,
                    emphasis: {
                        focus: 'series',
                        blurScope: 'coordinateSystem'
                    }
                  },
                  {
                    name: '1日增长',
                    type: 'line',
                    zlevel: 2,
                    //smooth: true,
                    data: rate1,
                    showSymbol: false,
                    areaStyle: {
                        opacity: 0.5
                    },
                    yAxisIndex: 1,//对应右侧的y轴
                    emphasis: {
                        focus: 'series',
                        blurScope: 'coordinateSystem'
                    }
                  },
                  {
                    name: '7日增长(日均)',
                    type: 'line',
                    zlevel: 3,
                    //smooth: true,
                    data: rate7,
                    showSymbol: false,
                    areaStyle: {
                        opacity: 0.2
                    },
                    yAxisIndex: 1,//对应右侧的y轴
                    emphasis: {
                        focus: 'series',
                        blurScope: 'coordinateSystem'
                    }
                  },
                  {
                    name: '14日增长(日均)',
                    type: 'line',
                    zlevel: 4,
                    //smooth: true,
                    data: rate14,
                    showSymbol: false,
                    areaStyle: {
                        opacity: 0.2
                    },
                    yAxisIndex: 1,//对应右侧的y轴
                    emphasis: {
                        focus: 'series',
                        blurScope: 'coordinateSystem'
                    }
                  },
                  {
                    name: '30日增长(日均)',
                    type: 'line',
                    zlevel: 5,
                    //smooth: true,
                    data: rate30,
                    showSymbol: false,
                    areaStyle: {
                        opacity: 0.2
                    },
                    yAxisIndex: 1,//对应右侧的y轴
                    emphasis: {
                        focus: 'series',
                        blurScope: 'coordinateSystem'
                    }
                  },
                  {
                    name: 'UP主粉丝量里程碑**',
                    type: 'scatter',
                    zlevel: 10,
                    symbol:'image://data:image/svg+xml,%3Csvg xmlns="http://www.w3.org/2000/svg" width="100" height="100" viewBox="0 0 100 100"%3E%3Cpath d="M10,10 L90,90 M10,90 L90,10" stroke="%23EE2222" stroke-width="20" fill="none" /%3E%3C/svg%3E',
                    symbolSize: 20,
                    itemStyle:{
                        normal:{
                            color:'#ee2222'
                        }
                    },
                    //smooth: true,
                    data: fans_nodes4chart,
                    showSymbol: true,
                    yAxisIndex: 0
                  },
                  {
                    name: '视图内最高粉丝记录',
                    type: 'scatter',
                    zlevel: 10,
                    symbol:'image://data:image/svg+xml,%3Csvg xmlns="http://www.w3.org/2000/svg" width="100" height="100" viewBox="0 0 100 100"%3E%3Cpath d="M35 100 L50 50 L65 100 Z" stroke="%23000000" stroke-width="3" fill="%23EE2222" /%3E%3C/svg%3E',
                    symbolSize: 30,
                    itemStyle:{
                        normal:{
                            color:'#ee2222'
                        }
                    },
                    //smooth: true,
                    data: [],
                    showSymbol: true,
                    yAxisIndex: 0
                  },
                  {
                    name: '视图内最低粉丝记录',
                    type: 'scatter',
                    zlevel: 10,
                    symbol:'image://data:image/svg+xml,%3Csvg xmlns="http://www.w3.org/2000/svg" width="100" height="100" viewBox="0 0 100 100"%3E%3Cpath d="M35 0 L50 50 L65 0 Z" stroke="%23000000" stroke-width="3" fill="%2322CC22" /%3E%3C/svg%3E',
                    symbolSize: 30,
                    itemStyle:{
                        normal:{
                            color:'#ee2222'
                        }
                    },
                    //smooth: true,
                    data: [],
                    showSymbol: true,
                    yAxisIndex: 0
                  }
                  ]
                };
                option && myChart.setOption(option);
                
                setTimeout(function(){
                myChart.on('datazoom', function() {
                  reload_chart();
                });
                },1000);
                function reload_chart() {
                    var option = myChart.getOption();
                    var chart_end = new Date(fans[fans.length-1][0].replace(' ', 'T')).setHours(24, 0, 0, 0);
                    var chart_start = new Date(fans[0][0].replace(' ', 'T')).setHours(0, 0, 0, 0);
                    var delta_time1 = (100-option.dataZoom[0].start)*(chart_end-chart_start)/100;
                    var delta_time2 = (100-option.dataZoom[0].end)*(chart_end-chart_start)/100;
                    function fans_max_min(fans, delta_time, delta_time2) {
                        var currentDate = new Date(fans[fans.length-1][0].replace(' ', 'T'));
                        currentDate.setHours(24, 0, 0, 0);
                        var maxFansCount = ['' ,null];
                        var minFansCount = ['' ,null];
                        
                        for (var i = fans.length-1; i >= 0; i--) {
                          if (currentDate - new Date(fans[i][0].replace(' ', 'T')) <= delta_time2) {
                              continue
                          }
                          if (currentDate - new Date(fans[i][0].replace(' ', 'T')) >= delta_time) {
                              break
                          }
                          if(maxFansCount[1]==null) {
                            maxFansCount = [fans[i][0], fans[i][1]];
                          }
                          if (fans[i][1] > maxFansCount[1]) {
                            maxFansCount = [fans[i][0], fans[i][1]];
                          }
                          if(minFansCount[1]==null) {
                            minFansCount = [fans[i][0], fans[i][1]];
                          }
                          if (fans[i][1] < minFansCount[1]) {
                            minFansCount = [fans[i][0], fans[i][1]];
                          }
                        }
                        return [maxFansCount, minFansCount];
                    }
                    option.series[9].data = [fans_max_min(fans, delta_time1, delta_time2)[0]];
                    option.series[10].data = [fans_max_min(fans, delta_time1, delta_time2)[1]];
                    myChart.setOption(option);
                }
                reload_chart(); //重载以加载视图内最高最低点
            }, 250);}
            window.addEventListener('resize', function() {
                if(typeof(myChart)!="undefined"){
                    myChart.resize();
                }
            });
            }
		</script>
</html>
