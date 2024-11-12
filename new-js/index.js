/*
document.write(`
    <script src="/new-js/bandev.js"></script>
    <script>
      devtoolsDetector.addListener(function (isOpen, detail) {
        console.log('isOpen', isOpen);

        if (isOpen) {
          document.head.innerHTML = "<meta charset='utf-8'>";
          document.body.className = "";
          document.body.innerHTML = "<div style='margin-left:15%;margin-right:15%;top:35%;position: fixed;'><img src='/Ivan.png' width=200px style='margin-left:-15px'><br><h1>你干嘛啊啊哈哟！！</h1><br><font color='grey'>Tips:后台有些东西不想让大家看到，所以没有需要的话就不要F12了</font></div>";
          debugger;
          location.reload();
        }
      });

      devtoolsDetector.launch();
    </script>
`);
*/

function alert(content, timeout){
    if (!timeout) timeout = 2500;
    mdui.snackbar({
      message: content,
      timeout: timeout
    });
}


if (!document.querySelector('nopop')) {
    if (!localStorage.getItem("first-visited")) {
      // 设置标记表示已访问过
      localStorage.setItem("first-visited", "true");
      
      document.write(`
        <div id="floating-window">
          <div id="floating-content">
            <p id="floating-message">在留言提问之前请先确定<br>你已经详阅左侧栏公告了~</p>
            <p><button id="floating-close-button" mdui-dialog="{target: '#announcement'}" onclick="document.getElementById('floating-window').style.display = 'none';">关闭</button></p>
          </div>
        </div>
      `);
      
      alert('您似乎是第一次来到本网站<br>为了您能更顺利地使用本网站，在提出任何疑问前请先查看侧栏中的公告，谢谢！', 10000)
    }
}



//切换图床
function switchImgBed() {
    let elements = document.querySelectorAll('[src*="us.pro-ivan."]:not([src*="!w"]), [href*="us.pro-ivan."]:not([href*="!w"]), [data-src*="us.pro-ivan."]:not([data-src*="!w"])');

    elements.forEach(function(element) {
        if (element.getAttribute('src')) {
            if (element.getAttribute('src').includes('us.pro-ivan.com')) {
                element.setAttribute('src', element.getAttribute('src').replace('us.pro-ivan.com', 'us.pro-ivan.cn')); console.log('switch uri');
            } else {
                element.setAttribute('src', element.getAttribute('src').replace('us.pro-ivan.cn', 'us.pro-ivan.com')); console.log('switch uri');
            }
        }
        if (element.getAttribute('data-src')) {
            if (element.getAttribute('data-src').includes('us.pro-ivan.com')) {
                element.setAttribute('data-src', element.getAttribute('data-src').replace('us.pro-ivan.com', 'us.pro-ivan.cn')); console.log('switch uri');
            } else {
                element.setAttribute('data-src', element.getAttribute('data-src').replace('us.pro-ivan.cn', 'us.pro-ivan.com')); console.log('switch uri');
            }
        }
        if (element.getAttribute('href')) {
            if (element.getAttribute('href').includes('us.pro-ivan.com')) {
                element.setAttribute('href', element.getAttribute('href').replace('us.pro-ivan.com', 'us.pro-ivan.cn')); console.log('switch uri');
            } else {
                element.setAttribute('href', element.getAttribute('href').replace('us.pro-ivan.cn', 'us.pro-ivan.com')); console.log('switch uri');
            }
        }
    });
}

// 测速
function getLoadTime(url) {
    return new Promise((resolve, reject) => {
        const startTime = performance.now();
        const xhr = new XMLHttpRequest();
        xhr.open('GET', url, true);
        xhr.setRequestHeader('Cache-Control', 'no-cache');
        xhr.setRequestHeader('Pragma', 'no-cache');
        xhr.onload = function() {
            const endTime = performance.now();
            const loadTime = endTime - startTime;
            resolve({ loadTime, responseTime: xhr.getResponseHeader('Date') });
        };
        xhr.onerror = function() {
            reject('请求出错');
        };
        xhr.send();
    });
}

Promise.all([
    getLoadTime('https://us.pro-ivan.cn/favicon.ico'),
    getLoadTime('https://us.pro-ivan.com/favicon.ico')
])
    .then(([site1, site2]) => {
        const site1Score = calculateScore(site1.loadTime, site1.responseTime);
        const site2Score = calculateScore(site2.loadTime, site2.responseTime);

        if (site1Score > site2Score) {
            switchImgBed();
            console.log('选择us.pro-ivan.cn');
        } else {
            console.log('选择us.pro-ivan.com');
        }
    })
    .catch(error => {
        console.error('发生错误：', error);
    });

function calculateScore(loadTime, responseTime) {
    // 这里可以根据具体情况定义一个综合评分算法
    // 例如，可以将下载速度和响应速度加权平均
    return (2 * loadTime + responseTime) / 3;
}

webdriver = window.navigator.webdriver;
if(webdriver){
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.abort(); 
    window.stop ? window.stop() : document.execCommand("Stop");
    alert('我在做网站的时候，你有在偷偷用Selenium爬我吧？(恼)')
    window.open('/', '_self')
} else {
    console.log('webdriver check 0K')
}

var UserAgent = 
{
    useragent:window.navigator.userAgent.toLowerCase(),
    android:function()
    {
        alert(this.useragent.indexOf("android"));
        return (this.useragent.indexOf("android") >=0);
    },
    iphone:function()
    {
        return (this.useragent.indexOf("iphone") >=0);
    },
    ipad:function()
    {
        return (this.useragent.indexOf("ipad") >=0);
    },
    mobile:function()
    {
    　　return (this.useragent.indexOf("andriod") >=0) || (this.useragent.indexOf("iphone") >=0) || (this.useragent.indexOf("ipad") >=0);
    }
}
if (UserAgent!='') console.log('UserAgent check 0K') 
else {
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.abort(); 
    window.stop ? window.stop() : document.execCommand("Stop");
    alert('你的UA咋是空的啊')
    window.open('/', '_self')
}

document.onkeydown = function() {
    var e = window.event || arguments[0];
    if (e.keyCode == 123) {
        alert("我求求你了，你也不管理这个网站F12干啥呀！");
        return false;
    }
     if ((e.ctrlKey) && (e.keyCode == 83)) { //ctrl+s
        alert("你存个html文件不怕我往里面藏毒吗(恼)");
        return false;
    }
     if ((e.ctrlKey) && (e.keyCode == 85)) { //ctrl+s
        alert("要看源代码是吧？我那💩山有什么好看的！");
        return false;
    }
    if ((e.ctrlKey) && (e.keyCode == 73)) { //ctrl+s
        alert("F12不行用这个是吧，你干脆直接右上角工具里找到开发者工具点开来得了呗！");
        return false;
    }
}




document.oncontextmenu = function() {
    alert('你！不准使用右键！');
    return false;
}

var httpRequest = new XMLHttpRequest();//第一步：建立所需的对象
httpRequest.open('GET', '/gonggao/index.php', true);
httpRequest.send();//第三步：发送请求  将请求参数写在URL中
/**
 * 获取数据后的处理程序
 */
httpRequest.onreadystatechange = function () {
    if (httpRequest.readyState == 4 && httpRequest.status == 200) {
        var gonggao = httpRequest.responseText;//获取到json字符串，还需解析
        document.getElementById('GG').innerHTML = gonggao
    }
};
function imgs() {
    window.open('/new-page1.php', '_self');
}
function about() {
    window.open('/new-about.html', '_self');
}
function comic() {
    window.open('/new-comic.php', '_self');
}
function img_bed() {
    window.open('/new-upload.html', '_self');
}
function little_game() {
    window.open('/game/', '_self');
}
function home() {
    window.open('/new.html', '_self');
}
function img_bed_files() {
    window.open('/upload_pic/', '_self');
}
function download() {
    window.open('/new-download.php', '_self');
}
function bfanscount() {
    window.open('/bilibili/', '_self');
}
function api() {
    window.open('/api/', '_blank');
}
function advertising() {
    window.open('/advertising.html', '_blank');
}
function line_1() {
    //具体咋写，我不知道，域名跳转？
    alert('将跳转到pro-ivan.cn');
    setTimeout(function() {
        window.location.href="https://pro-ivan.cn";
    }, 2500)
}
function line_2() {
    //具体咋写，我不知道，域名跳转？
    alert('将跳转到www.pro-ivan.cn');
    setTimeout(function() {
        window.location.href="https://www.pro-ivan.cn";
    }, 2500)
}
function line_3() {
    //具体咋写，我不知道，域名跳转？
    alert('将跳转到pro-ivan.com');
    setTimeout(function() {
        window.location.href="https://pro-ivan.com";
    }, 2500)
}
function line_4() {
    //具体咋写，我不知道，域名跳转？
    alert('将跳转到www.pro-ivan.com');
    setTimeout(function() {
        window.location.href="https://www.pro-ivan.com";
    }, 2500)
}

// 动态添加meta资源https
if (window.location.protocol.split(":")[0] == 'https') {
	var meta = document.createElement('meta');
	meta.content = "upgrade-insecure-requests";
	meta.setAttribute('http-equiv', "Content-Security-Policy");
	document.getElementsByTagName('head')[0].appendChild(meta);
}

function closewin(){
    document.getElementById('float_win').style.visibility='hidden' ;
}

function rickroll(){
    window.location.href="https://vdse.bdstatic.com//192d9a98d782d9c74c96f09db9378d93.mp4";
}

// 全局错误处理函数
window.onerror = function(message, source, lineno, colno, error) {
  alert('加载异常，请尝试刷新或向我们报告，不影响使用则忽略此信息：<br>' + message + ' in ' + lineno + ', ' + colno, 10000);
};

// 向新元素中添加 到顶端 的快捷键
var newText = `<button class="mdui-fab mdui-fab-fixed mdui-ripple mdui-color-theme mdui-text-color-white-text" onclick="window.scrollTo({top: 0,behavior: 'smooth'});" style="opacity: 0.75;"><i class="mdui-icon material-icons">arrow_upward</i></button>`;
document.write(newText);

//节日祝福设置
var holidayWishes = [
  { date: "01-01", message: "祝元旦快乐！", cookieName: "new-year-wish-received" }, // 元旦
  { date: "02-09", message: "祝除夕快乐，希望来年也能多多支持！", cookieName: "chinese-new-year-eve-wish-received" }, // 春节
  { date: "02-10", message: "祝春节快乐！", cookieName: "chinese-new-year-wish-received" }, // 春节
  { date: "04-05", message: "祝清明节安康！", cookieName: "qingming-festival-wish-received" }, // 清明节
  { date: "05-01", message: "祝劳动节快乐！", cookieName: "labor-day-wish-received" }, // 劳动节
  { date: "05-04", message: "祝青年节快乐！", cookieName: "youth-day-wish-received" }, // 青年节
  { date: "06-01", message: "祝儿童节快乐！就算成年了也要保持童心哦~", cookieName: "childrens-day-wish-received" }, // 儿童节
  { date: "06-07", message: "祝各位学子高考顺利！", cookieName: "gaokao-wish-received" }, // 高考
  { date: "06-22", message: "祝端午节安康！", cookieName: "dragonboat-festival-wish-received" }, // 端午节
  { date: "09-17", message: "祝中秋节快乐！", cookieName: "mid-autumn-wish-received" }, // 中秋节
  { date: "10-01", message: "祝国庆节快乐！", cookieName: "national-day-wish-received" }, // 国庆节
  { date: "12-25", message: "祝圣诞节快乐！", cookieName: "christmas-wish-received" } // 圣诞节
];


function checkForHolidayWishes() {
  var today = new Date();
  var monthDayStr = today.toLocaleDateString("zh-CN", { month: "2-digit", day: "2-digit" }).replace('/', '-');

  for (var i = 0; i < holidayWishes.length; i++) {
    var holiday = holidayWishes[i];
    var alreadyReceived = localStorage.getItem(holiday.cookieName) || false;

    if (monthDayStr === holiday.date && !alreadyReceived) {
      alert(holiday.message, 8000);
      console.log("假期祝福已送出~")
      localStorage.setItem(holiday.cookieName, true);
    }
    else if(monthDayStr === holiday.date && alreadyReceived) console.log("已经送过祝福了~");
  }
}

checkForHolidayWishes();


if(document.getElementById("footer")!=null){
    let footer_content = '<br>';
    if (!document.querySelector('nofootertitle')) {
        footer_content += '<HR style="FILTER:alpha(opacity=100,finishopacity=0,style=3)" width="90%" color=#C0C0C0 SIZE=3><div class="mdui-container-fluid"><h3 id="留言板">留言板</h3>';
    }
    footer_content += `
    <div class="mdui-table-fluid mdui-table th" style="width:100%;">
        <form id="comment_form">
            <table class="mdui-table">
                <tbody>
                    <tr>
                        <th>
                            <label class="mdui-textfield-label">昵称</label>
                            <input type="text" class="mdui-textfield-input" name="name" placeholder="请输入昵称(小于25字)" required="required" maxlength="25" style="width:98%;">
                            <br>
                            <label class="mdui-textfield-label">评论</label>
                            <input type="text" class="mdui-textfield-input" name="comment" placeholder="要讲文明哟~(小于200字)" required="required" maxlength="200" style="width:98%;">
                            <br>
                            <label class="mdui-textfield-label">电邮</label>
                            <input type="text" class="mdui-textfield-input" name="contact" placeholder="或者其他联系方式（选填）" maxlength="200" style="width:98%;">
                            <br>
                            <center>
                                <input class="mdui-btn mdui-ripple mdui-btn-raised mdui-btn-dense mdui-color-theme" type="submit" id="submitButton" value="发送" onclick="">
                            </center>
                        </th>
                    </tr>
                </tbody>
            </table>
        </form>

        <div id="comment_result"></div>
        <script>
            document.getElementById('comment_form').addEventListener('submit', function(event) {
                event.preventDefault(); // 阻止表单的默认提交行为
    
                // 获取表单数据
                const formData = new FormData(this);
    
                // 使用Fetch API发送AJAX请求
                fetch('/comment/comment.php', {
                    method: 'POST',
                    body: formData
                })
                .then(response => response.text())
                .then(html => {
                    // 将返回的HTML插入到页面的特定位置
                    document.getElementById('comment_result').innerHTML = html;
                })
                .then(() => {
                    //清空表单
                    var form = document.getElementById('comment_form');
                    if (form) {
                        var inputs = form.getElementsByTagName('input');
                        for (var i = 0; i < inputs.length; i++) {
                            if (inputs[i].type === 'text') {
                                inputs[i].value = '';
                            }
                        }
                    }
                    //刷新embed
                    var embedElement = document.getElementById('comment_embed');
                    if (embedElement) {
                        var currentSrc = embedElement.src;
                        embedElement.src = currentSrc; // 重新设置相同的src以刷新内容
                    } else {
                        console.error('Embed element not found.');
                    }
                })
                .catch(error => console.error('Error:', error));
            });
        </script>
        
        <br>
        <embed id="comment_embed" src="/sql_comment/" width="90%"/>
    </div>
    <br>
    <div style="margin-bottom:15px;">
        <font size="2" color="#C0C0C0">Designed by <a href="https://github.com/Tvogmbh/" target="_blank" style="display:inline-block;text-decoration: none;"><font size="2" color="#C0C0C0" target="_blank">Tvogmbh</font></a> · ©2022-2024 Pro-Ivan Studio</font>
        <br>
        <a href="https://stats.uptimerobot.com/Oo6ykFNrDn" target="_blank" style="display:inline-block;text-decoration: none;"><font size="2" color="#C0C0C0">站点在线状态</font></a>
        <font size="2" color="#C0C0C0"> · </font>
        <a href="/test_server/" target="_blank" style="display:inline-block;text-decoration: none;"><font size="2" color="#C0C0C0">服务器状态</font></a>
        <br>
        <font size="2" color="#C0C0C0">友情链接 · </font>
        <a href="https://acg.umoes.top/" target="_blank" style="display:inline-block;text-decoration: none;"><font size="2" color="#C0C0C0">Yoo！萌</font></a>
        <font size="2" color="#C0C0C0"> · </font>
        <a href="https://sweetily.club/" target="_blank" style="display:inline-block;text-decoration: none;"><font size="2" color="#C0C0C0">Sweetily的粉丝站</font></a>
        <font size="2" color="#C0C0C0"> · </font>
        <a href="https://momomitsuki.com/" target="_blank" style="display:inline-block;text-decoration: none;"><font size="2" color="#C0C0C0">美月もも的粉丝站</font></a>
        <font size="2" color="#C0C0C0"> · </font>
        <a href="https://objection.yvfox.com" target="_blank" style="display:inline-block;text-decoration: none;"><font size="2" color="#C0C0C0">坎尤的一斤鸭梨</font></a>
        <br>
        <a href="//beian.miit.gov.cn" style="display:inline-block;text-decoration:none;height:20px;line-height:20px;" target="_blank"><font size="2" color="#C0C0C0">京ICP备2022003448号-1/2</font></a>
        <font size="2" color="#C0C0C0"> · </font>
        <a target="_blank" href="//www.beian.gov.cn/portal/registerSystemInfo?recordcode=11011402012324" style="display:inline-block;text-decoration:none;height:20px;line-height:20px;"><img src="/beian.png" style="float:left;"/><font size="2" color="#C0C0C0">京公网安备 11011402012324号</font></a>
        <font size="2" color="#C0C0C0"> · </font>
        <a href="https://icp.gov.moe/?keyword=20241113" style="display:inline-block;text-decoration:none;height:20px;line-height:20px;" target="_blank"><font size="2" color="#C0C0C0">萌ICP备20241113号</font></a>
    </div>
    `;
    document.getElementById('footer').innerHTML = footer_content;
    var scriptElement = document.createElement('script');
    scriptElement.text = document.getElementById('footer').querySelector('script').innerHTML;
    document.getElementById('footer').appendChild(scriptElement);
}
//页面标题防止溢出
setTimeout(function() {
    if(document.getElementById('body').offsetWidth<=720&&document.getElementById('title').innerHTML.length>18){
        document.getElementById('title').style.fontSize  = '14px';
    } else if (document.getElementById('body').offsetWidth<=720&&document.getElementById('title').innerHTML.indexOf("图库") != -1) {
        document.getElementById('title').style.fontSize  = '16px';
    } else if(document.getElementById('body').offsetWidth<=720&&document.getElementById('title').innerHTML.length>14) {
            document.getElementById('title').style.fontSize  = '18px';
    }
}, 250);



console.log(`
  赛博邪祟  知虫之名
  急需DE去  不得久停
☯ - 急 急 如 律 令 - ☯

      $$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$  
       $$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$  
           $$$$$$$$ 
           $$$$$$$$      $$$$$$          $$$$$$$$$$       $$$$$$$        $$$$$
           $$$$$$$$       $$$$$$        $$$$$$$$$$$$      $$$$$$$$       $$$$$ 
           $$$$$$$$       $$$$$$        $$$$$$  $$$$$     $$$$$$$$$      $$$$$        
           $$$$$$$$        $$$$$$      $$$$$$    $$$$$    $$$$$$$$$$$    $$$$$
           $$$$$$$$         $$$$$$    $$$$$$      $$$$$   $$$$$ $$$$$$   $$$$$        
           $$$$$$$$          $$$$$$  $$$$$$$$$$$$$$$$$$$  $$$$$  $$$$$$  $$$$$       
           $$$$$$$$           $$$$$$$$$$$$$$$$$$$$$$$$$$$ $$$$$    $$$$$ $$$$$  
           $$$$$$$$           $$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$     $$$$$$$$$$
           $$$$$$$$            $$$$$$$$$$            $$$$$$$$$$      $$$$$$$$$ 
           $$$$$$$$             $$$$$$$$              $$$$$$$$$        $$$$$$$
           $$$$$$$$              $$$$$$                $$$$$$$$         $$$$$$ 
           $$$$$$$$ 
           $$$$$$$$   $$$$$$$  $$$$$$$$    $$$$$$   $$$$$$$  $$$$     $$$$$$  $$$$$$$$$       
           $$$$$$$$   $$$  $$$ $$$  $$$$  $$$  $$$ $$$$$$$$ $$$$$$   $$$  $$  $$$$$$$$$       
           $$$$$$$$   $$$  $$$ $$$   $$$ $$$   $$$    $$$   $$ $$$  $$$       $  $$$  $       
           $$$$$$$$   $$$$$$$$ $$$$$$$$$ $$$   $$$    $$$  $$   $$  $$$    $     $$$          
           $$$$$$$$   $$$$$$$  $$$$$$$    $$$ $$$$ $  $$$ $$$$$$$$$  $$$  $$     $$$         
           $$$$$$$$   $$$   $$ $$$   $$$  $$$$$$$  $$$$$$ $$    $$$  $$$$$$$     $$$             
           $$$$$$$$   $$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$         
        $$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$
       $$$$$$$$$$$$$$$   

WELCOME! MY FRIEND!!!

Pro-Ivan All Right Reserve · ROID: 20211114s10001s41369525-cn
`)
