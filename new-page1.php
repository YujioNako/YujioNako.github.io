<?php
session_start();
//记录来自哪个界面
$current_page = $_SERVER['REQUEST_URI'];
$_SESSION['comeFrom'] = $current_page;

if (!isset($_SESSION['visited'])) {
  header("Location:/antiBot/");
  exit();
}

?>

<!doctype html>
<html lang="zh-cmn-Hans">
	<head>
		<meta charset="utf-8">
		<meta name="robots" content="noindex,follow"/>
		<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" />
		<meta name="renderer" content="webkit" />
		<meta name="force-rendering" content="webkit" />
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
		<script type="text/javascript" src="/passport/passcheck.php"></script>
		<link rel="shortcut icon" href="/favicon.ico">
    	<script src="/mdui/js/mdui.min.js"></script>
		<link rel="stylesheet" href="/mdui/css/mdui.css" />
		<link rel="stylesheet" href="/new-js/index.css">
        <?php
        function compressIfNeeded($sourceFile, $compressedFile) {
            if (!file_exists($sourceFile)) {
                throw new Exception("Source file does not exist: $sourceFile");
            }
        
            $sourceModifiedTime = filemtime($sourceFile);
            $compressedModifiedTime = file_exists($compressedFile) ? filemtime($compressedFile) : 0;
        
            if ($sourceModifiedTime > $compressedModifiedTime) {
                // 压缩内容
                $content = file_get_contents($sourceFile);
                $compressedContent = gzcompress($content);
                file_put_contents($compressedFile, $compressedContent);
                echo "<script>let update = true;</script>";
            } else {
                echo "<script>let update = false;</script>";
            }
        }
        
        // 调用函数进行检查和压缩
        try {
            compressIfNeeded('data/img_content.html', 'data/img_content_compressed.gz');
        } catch (Exception $e) {
            echo 'Error: ',  $e->getMessage(), "\n";
        }
        ?>
		<style>
            .bottom { position: fixed; bottom: -700px; right: -800px; align:center;pointer-events: auto;z-index:2000;}
            .lazy { margin-top: 120px; margin-bottom: 120px; width: 100%; }
            @media (max-width: 720px) {
                .lazy { margin-top: 60px; margin-bottom: 60px;}
            }
            .shown  { width: 100%; }

            .showImg {
                cursor: zoom-in;
                display: inline-block;
                width: 18%;
            }
            
            #overlay,#loading_l {
              position: fixed;
              top: 0;
              left: 0;
              width: 100%;
              height: 100%;
              background-color: rgba(0, 0, 0, 0.8);
              display: none;
              justify-content: center;
              align-items: center;
              z-index: 9999;
              transition: all 0.5s ease-in-out;
            }
            
            #loading_l {display: block; background-color: rgba(0, 0, 0, 0.6);}
            
            #prevBtn, #nextBtn {
                position: absolute;
                top: 50%;
                transform: translateY(-50%);
                background: none;
                border: none;
                cursor: pointer;
                pointer-events: auto;
                color: #fff;
                z-index: 10001;
            }
            
            #prevBtn i, #nextBtn i, #closeBtn i {
                font-size: 3.5em;
            }
        
            #prevBtn {
                left: 15px;
            }
        
            #nextBtn {
                right: 15px;
            }
            
            #popupImg {
              max-width: 90%;
              max-height: 90%;
              /*pointer-events: none;*/
              cursor: zoom-in;
              transition: all 0.5s ease-in-out;
              z-index: 10000;
            }
            
            #overlay p {
              width: 100%;
              text-align: center;
              position: fixed;
              color: white;
              font-weight: bold;
              font-size: 24px;
            }
            
            #closeBtn {
              position: absolute;
              top: 10px;
              right: 15px;
              color: #fff;
              cursor: pointer;
              pointer-events: auto;
              z-index: 10001;
              transition: all 0.5s ease-in-out;
            }
        </style>
		<title>Pro-Ivan数字库-图库</title>
		<meta name="keywords" content="动漫图片,动漫资讯,动漫,二次元,漫画,动画,游戏,Cosplay,ACG,番剧,视频分享,壁纸,神曲,热门动漫,热门番剧">
		<meta name="description" content="技术宅社团，什么活都整！">
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
	<body class="mdui-drawer-body-left mdui-theme-primary-light-blue">
        <div id="loading_b" class="mdui-dialog mdui-dialog-open" style="display: block;position: fixed;top: 0px;left: 0px;right: 0px;bottom: 0px;margin: auto;max-height:23%;pointer-events: none;">
	        <div class="mdui-dialog-title" style="pointer-events: none;">请知悉</div>
            <div class="mdui-dialog-content" style="pointer-events: none;">本页面内的图片可能不适合在公开场合浏览，请留意您所在的场合<br>我们不会承担您在社会层面上的死亡风险<br>出现UI格式问题请刷新页面</div>
            <div class="mdui-dialog-actions" style="position: absolute; top: 0px; right: 20px;">
                <span onclick="document.getElementById('loading_b').className='mdui-dialog';
                document.getElementById('loading_l').className='mdui-overlay';" style="pointer-events: auto; cursor: pointer;color:gray;font-size:3.0em;">&times;</span>
            </div>
        </div>
	    <div id="loading_a" class="mdui-dialog mdui-dialog-open" style="display: block;position: fixed;top: 0px;left: 0px;right: 0px;bottom: 0px;margin: auto;max-height:23%;pointer-events: none;">
	        <div class="mdui-dialog-title" style="pointer-events: none;">请稍等</div>
            <div class="mdui-dialog-content" style="pointer-events: none;">本页面资源量较大，需要一定时间准备……<br>如果是第一次打开本页，等待时间可能更长</div>
            <div class="mdui-progress" style="position: fixed; bottom: 5%; align:center;">
              <div class="mdui-progress-indeterminate"></div>
            </div>
        </div>
        <div id="loading_l" class="mdui-overlay mdui-overlay-show" style="z-index: 3000;"></div>
        <div id="overlay">
            <span id="closeBtn"><i class="mdui-icon material-icons">close</i></span>
            <img id="popupImg" src="" alt="弹出图片" onclick="window.open(document.getElementById('popupImg').src, '_blank');">
            <p>正在加载 请稍后……<br>Now Loading……</p>
            <span id="prevBtn"><i class="mdui-icon material-icons">keyboard_arrow_left</i></span>
            <span id="nextBtn"><i class="mdui-icon material-icons">keyboard_arrow_right</i></span>
        </div>
		<div class="mdui-drawer" id="left-drawer" style="z-index:3000;">
			<img src="./Ivan.svg" style="max-width: 100%; max-height: 100%;">
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
				<li class="mdui-list-item mdui-ripple" onclick="alert('you are here')">
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
				<li class="mdui-list-item mdui-ripple" onclick="bfanscount()">
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
				<li class="mdui-list-item mdui-ripple" onclick="advertising()">
					<i class="mdui-list-item-icon mdui-icon material-icons">web</i>
					<div class="mdui-list-item-content">友链&推介</div>
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
		<div class="mdui-appbar">
			<div class="mdui-toolbar mdui-color-theme" style="position:fixed;z-index:1000;margin-top:-15px;" mdui-headroom>
				<a href="javascript:;" mdui-drawer="{target: '#left-drawer'}" class="mdui-btn mdui-btn-icon">
					<i class="mdui-icon material-icons">menu</i>
				</a>
				<a id="title" href="/new.html" class="mdui-typo-headline">Pro-Ivan数字库-图库</a>
				<div class="mdui-toolbar-spacer"></div>
				<a href="javascript:loadModel();" class="mdui-btn mdui-btn-icon" mdui-tooltip="{content: '开启/刷新桌面宠物'}">
					<i class="mdui-icon material-icons">refresh</i>
				</a>
				<a href="javascript:switchImgBed();alert('线路已切换');" class="mdui-btn mdui-btn-icon" mdui-tooltip="{content: '切换图床线路'}">
					<i class="mdui-icon material-icons">swap_horiz</i>
				</a>
				<a href="javascript:;" class="mdui-btn mdui-btn-icon" onclick="AddFavorite('http://pro-ivan.cn','Pro-Ivan')">
					<i class="mdui-icon material-icons" mdui-tooltip="{content: '收藏本页'}">star</i>
				</a>
			</div>
		</div>
		
		<div id="body" class="mdui-container-fluid">
		    <div class="mdui-toolbar"></div>
			<h3>注意</h3>
			<p>
				<b>· 从2021.11.16起对低画质(文件大小小于150kb或任意一边像素数小于1000px)的图片会进行AI增强，要查看原图请点击图片</b>
			</p>
			<p>
				<b>· 对于第一次打开或在清除网页缓存后打开本网页的用户，可能出现图片访问403的情况，这是为了防止CDN流量被滥用，届时请耐心等待2-3分钟以等待服务恢复</b>
			</p>
			<p>
			    · 本页面上次更新于 <span id='LastUpdate'><?php $filename = 'data/img_content_compressed.gz';$last_modified = date("Y-n-d H:i:s", filemtime($filename));echo $last_modified; ?></span>
			</p>
			<div id="img_content" class="mdui-panel" mdui-panel>
                
                 <center style="line-height: 4; padding-top: 4em; padding-bottom: 4em;"><h1>加载中/Now Loading</h1></center>
				
			</div>
			
		</div>
		<div id="live2d" class="bottom" style="pointer-events: none;">
            <canvas></canvas>
        </div>
	<footer><div id="footer"></div></footer>
	<script src="/new-js/index.js"></script>
	</body>
    <script src="./mdui/js/mdui.min.js"></script>
	<script src="./live2d/pixi/pixi.min.js"></script>
    <script src="./live2d/core/live2dcubismcore.min.js"></script>
    <script src="./live2d/framework/live2dcubismframework.js"></script>
    <script src="./live2d/framework/live2dcubismpixi.js"></script>
    <script src="./live2d/loadModel.js"></script>
    <script>
            //loadModel();
    </script>
    <script>
        async function loadCompressedContent() {
            let header = update ? `{"Cache-Control": "no-cache"}`:`{}`;
            fetch('/data/img_content_compressed.gz', {
                    headers: JSON.parse(header)
                })
                .then(async (response) => await response.arrayBuffer())
                .then(async (buffer) => {
                    const compressedContent = new Uint8Array(buffer);
                    const decompressedContent = await pako.inflate(compressedContent, { to: 'string' });
                    document.getElementById('img_content').innerHTML = decompressedContent;
                })
                .then(async () => {
                    // 获取所有带有 "lazy" 类名的图片元素
                    const lazyImages = document.querySelectorAll('.lazy');
                
                    // 创建 Intersection Observer 实例
                    const observer = new IntersectionObserver((entries, observer) => {
                      entries.forEach(entry => {
                        // 如果图片进入视窗范围并且停留超过1000ms
                        //console.log(entry.intersectionRatio)
                        if (entry.intersectionRatio >= 0.025) {
                          const img = entry.target;
                
                          // 停留 1000ms 后加载图片
                          const timeoutId = setTimeout(() => {
                            img.onload = function() {
                                img.classList.remove('lazy');
                                img.classList.add('shown');
                                observer.unobserve(img);
                                img.style.paddingTop = '0';
                                img.style.paddingBottom = '0';
                            };
                            img.src = img.dataset.src;
                            //console.log('load')
                          }, 1000);
                
                          // 如果图片在 1000ms 内脱离视窗，则取消加载
                          const cancelTimeout = () => {
                            clearTimeout(timeoutId);
                            //console.log('cancel')
                          };
                
                          // 监听图片脱离视窗事件
                          const visibilityObserver = new IntersectionObserver(([visibilityEntry]) => {
                            if (visibilityEntry.intersectionRatio < 0.025) {
                              cancelTimeout();
                            }
                          });
                
                          visibilityObserver.observe(img);
                
                          // 监听图片加载完成事件
                          img.addEventListener('load', () => {
                            cancelTimeout();
                          });
                        }
                      });
                    });
                
                    // 遍历所有图片元素并开始观察
                    lazyImages.forEach(image => {
                      observer.observe(image);
                    });
                })
                    // 给每个缩略图添加点击事件
                .then(async () => {
                    
                    
                    var thumbnails = document.querySelectorAll('.showImg');
                    var currentIndex = 0;
                
                    function switchImage(direction) {
                        if (direction === 'prev' && currentIndex > 0) {
                            currentIndex--;
                        } else if (direction === 'next' && currentIndex < thumbnails.length - 1) {
                            currentIndex++;
                        }
                
                        var popupImg = document.getElementById('popupImg');
                        popupImg.style.display = 'none'; // 先隐藏图片
                        popupImg.onload = function() {
                            popupImg.style.display = 'block'; // 图片加载完成后显示
                        };
                        var imgSrc = thumbnails[currentIndex].getAttribute('src');
                        popupImg.src = imgSrc;
                    }
                
                    function openPopup(index) {
                        currentIndex = index;
                        var popupImg = document.getElementById('popupImg');
                        popupImg.style.display = 'none'; // 先隐藏图片
                        popupImg.onload = function() {
                            popupImg.style.display = 'block'; // 图片加载完成后显示
                        };
                        var imgSrc = thumbnails[currentIndex].getAttribute('src');
                        popupImg.src = imgSrc;
                    }
                
                    document.getElementById('prevBtn').addEventListener('click', function() {
                        switchImage('prev');
                    });
                
                    document.getElementById('nextBtn').addEventListener('click', function() {
                        switchImage('next');
                    });
                    
                    console.log(thumbnails.length);
                    for (var i = 0; i < thumbnails.length; i++) {
                        thumbnails[i].addEventListener('click', function() {
                            var index = Array.prototype.indexOf.call(thumbnails, this);
                            openPopup(index);
                        });
                    }
                })
                .then(async() => {
                    document.getElementById('loading_a').className="mdui-dialog";
                    
                    // 获取所有带有 "showImg" 类名的图片元素
                    var images = document.querySelectorAll('.showImg');
                
                    // 弹出图片的容器和关闭按钮
                    var overlay = document.getElementById('overlay');
                    var closeBtn = document.getElementById('closeBtn');
                
                    // 点击图片时弹出图片
                    images.forEach(function(image) {
                      image.addEventListener('click', function() {
                        var src = image.getAttribute('src');
                        document.getElementById('popupImg').setAttribute('src', src);
                        overlay.style.display = 'flex';
                      });
                    });
                
                    // 点击关闭按钮时关闭弹出图片
                    closeBtn.addEventListener('click', function() {
                      overlay.style.display = 'none';
                    });
                
                    // 监听窗口大小变化，适配横屏或竖屏
                    window.addEventListener('resize', function() {
                      var popupImg = document.getElementById('popupImg');
                      if (window.innerWidth > window.innerHeight) {
                        // 横屏
                        popupImg.style.maxWidth = '90%';
                        popupImg.style.maxHeight = '90%';
                      } else {
                        // 竖屏
                        popupImg.style.maxWidth = '90%';
                        popupImg.style.maxHeight = '90%';
                      }
                    });
                })
                .catch(error => console.error('Error loading compressed content:', error));
        }

        document.addEventListener('DOMContentLoaded', loadCompressedContent);
    </script>
    <script src="/new-js/pako.min.js"></script>
	<script>
	    function isInclude(name){
            var js= /php$/i.test(name);
            var es=document.getElementsByTagName(js?'script':'link');
            for(var i=0;i<es.length;i++) 
            if(es[i][js?'src':'href'].indexOf(name)!=-1)return true;
            return false;
        }
         
        //alert(isInclude("passcheck.php"));
        if(!isInclude("passcheck.php")) window.open('/passport/passgive.php', '_self');
	</script>
</html>