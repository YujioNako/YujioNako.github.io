<?php
session_start();

?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>验证码</title>
		<link rel="stylesheet" href="/mdui/css/mdui.css" />
		<link rel="stylesheet" href="/new-js/index.css">
    	<script src="/mdui/js/mdui.min.js"></script>
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
<body class="mdui-theme-primary-light-blue mdui-theme-accent-light-blue mdui-table-fluid mdui-table th mdui-panel-item-body mdui-container-fluid" style="max-width: 1200px;">
    <h1>为了服务器的内容安全，我们不得不加入了简单的人机验证</h1>
    <form id="submit_form"class="mdui-textfield mdui-textfield-floating-label" style="width: 80%;display: inline-block;">
        <i class="mdui-icon material-icons">android</i>
        <label class="mdui-textfield-label">请输入验证码</label>
        <input class="mdui-textfield-input" type="text" name="captcha" id="captcha" style="display:inline" />
        <input id="submit_btn" class="mdui-btn mdui-color-theme mdui-text-color-white-text" type="submit" value="提交" style="display: none;" />
    </form>
    <img id="captchaImg" src="./captcha.php" alt="验证码" style="margin-right:24px;float:right;width:12%;" />
	<div id="submit_result"></div>
    <script>
        document.getElementById('submit_form').addEventListener('submit', function(event) {
            event.preventDefault(); // 阻止表单的默认提交行为
            document.getElementById('submit_btn').disabled = true;
            document.getElementById('submit_btn').innerHTML = '验证中';

            // 获取表单数据
            const formData = new FormData(this);

            // 使用Fetch API发送AJAX请求
            fetch('./process.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.text())
            .then(html => {
                // 将返回的HTML插入到页面的特定位置
                document.getElementById('submit_result').innerHTML = html;
                var form = document.getElementById('submit_form');
                if (form) {
                    var inputs = form.getElementsByTagName('input');
                    for (var i = 0; i < inputs.length; i++) {
                        if (inputs[i].type === 'text') {
                            inputs[i].value = '';
                        }
                    }
                }
                document.getElementById('submit_btn').disabled = false;
                document.getElementById('submit_btn').innerHTML = '提交';
            })
            .catch(error => console.error('Error:', error));
        });
    </script>
    <br>
    <button class="mdui-btn mdui-color-theme mdui-text-color-white-text" type="button" onclick="document.getElementById('submit_btn').click();"  style="margin-right:24px;float:right;">提交</button>
    <button class="mdui-btn mdui-color-theme mdui-text-color-white-text" type="button" onclick="document.getElementById('captchaImg').src='';document.getElementById('captchaImg').src='./captcha.php';"  style="margin-right:24px;float:right;">刷新</button>
</body>
</html>
<!--
cnm，爬爬爬爬牛魔爬，老子服务器都被牛魔酬宾给爬烂了！
-->
